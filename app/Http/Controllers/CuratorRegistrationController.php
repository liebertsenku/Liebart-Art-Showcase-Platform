<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CuratorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class CuratorRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('curator.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'organization_name' => ['required', 'string', 'max:255'],
            'organization_website' => ['nullable', 'url'],
            'portfolio_link' => ['nullable', 'url'],
            'reason_for_applying' => ['required', 'string', 'min:20'],
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat User (Role: curator_pending)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'curator_pending', // Role sementara sebelum diapprove
            ]);

            // 2. Buat Profil Curator
            CuratorProfile::create([
                'user_id' => $user->id,
                'organization_name' => $request->organization_name,
                'organization_website' => $request->organization_website,
                'portfolio_link' => $request->portfolio_link,
                'reason_for_applying' => $request->reason_for_applying,
                'status' => 'pending',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        // Redirect ke halaman "Menunggu Persetujuan"
        return redirect()->route('curator.pending_notice');
    }

    public function pendingNotice()
    {
        return view('curator.pending_notice');
    }
}