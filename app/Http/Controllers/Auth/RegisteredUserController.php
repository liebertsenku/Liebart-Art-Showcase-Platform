<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'string', 'in:member,curator'], // Validasi role
    ]);

    // Tentukan status berdasarkan role
    $status = $request->role === 'curator' ? 'pending' : 'active';

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role, // Simpan role
        'status' => $status,         // Simpan status
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Setelah login, arahkan ke redirect yang benar
    // Kita akan tangani ini di Langkah 5, tapi untuk sekarang:
    if ($user->isPending()) {
        return redirect()->route('curator.pending'); // Arahkan ke halaman pending
    }

   return redirect('/dashboard');
}
}
