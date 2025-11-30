<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User; // <--- Import Model User
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil publik (Portfolio Style).
     * Diakses via: /member/{id}
     */
    public function show($id): View
    {
        // 1. Ambil User & Artwork
        $user = User::with('artworks')->findOrFail($id);
        
        // 2. Data Dummy Statistik
        $stats = [
            'artworks'  => $user->artworks->count(),
            'followers' => rand(100, 5000), 
            'likes'     => rand(50, 10000),
        ];

        // 3. Tampilkan View Publik
        return view('profile.show', compact('user', 'stats'));
    }

    /**
     * Menampilkan form edit profile.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profil user (Foto, Bio, Nama, Email).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());
        $user->instagram = $request->input('instagram');
        $user->behance = $request->input('behance');
        $user->website = $request->input('website');

        // --- UPDATE FOTO PROFIL ---
        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // --- UPDATE BIO ---
        if ($request->has('bio')) {
            $user->bio = $request->input('bio');
        }

        // Reset verifikasi email jika berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}