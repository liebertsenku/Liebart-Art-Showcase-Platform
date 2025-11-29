<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CuratorProfile; // <--- Import Model CuratorProfile
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // <--- Import DB untuk Transaction
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Dasar (User)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:member,curator'],
        ]);

        // 2. Validasi Tambahan (KHUSUS CURATOR)
        if ($request->role === 'curator') {
            $request->validate([
                'organization_name' => ['required', 'string', 'max:255'],
                'reason_for_applying' => ['required', 'string', 'min:10'],
                'portfolio_link' => ['nullable', 'url'],
            ]);
        }

        // 3. Eksekusi Database (Gunakan Transaction agar aman)
        DB::transaction(function () use ($request) {
            
            // Tentukan Role Database
            // Jika dia pilih curator, statusnya harus 'curator_pending' dulu agar tidak langsung punya akses
            $roleToSave = ($request->role === 'curator') ? 'curator_pending' : 'member';

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $roleToSave,
            ]);

            // Jika Curator, Simpan Data Profilnya
            if ($request->role === 'curator') {
                CuratorProfile::create([
                    'user_id' => $user->id,
                    'organization_name' => $request->organization_name,
                    'reason_for_applying' => $request->reason_for_applying,
                    'portfolio_link' => $request->portfolio_link,
                    'status' => 'pending', // Wajib pending
                ]);
            }

            event(new Registered($user));
            Auth::login($user);
        });

        // 4. Redirect sesuai Role
        // Jika curator, lempar ke halaman "Menunggu Persetujuan"
        if ($request->role === 'curator') {
            return redirect()->route('curator.pending_notice');
        }

        // Jika member biasa, lempar ke Home
        return redirect(route('home', absolute: false));
    }
}