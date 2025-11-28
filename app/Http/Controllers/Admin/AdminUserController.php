<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('artworks')->latest();

        // Simple Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount(['artworks', 'likes', 'comments']);
        $recentArtworks = $user->artworks()->latest()->take(6)->get();
        
        return view('admin.users.show', compact('user', 'recentArtworks'));
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus sesama Admin.');
        }

        DB::transaction(function () use ($user) {
            // 1. Hapus Semua Karya (Soft Delete)
            $user->artworks()->delete();

            // 2. Hapus Interaksi (Komentar, Likes, Favorites)
            // Note: Karena ini relasi pivot atau table lain, kita delete manual
            // agar bersih, meskipun user sudah soft deleted.
            $user->likes()->detach();
            $user->favorites()->detach();
            $user->comments()->delete();

            // 3. Hapus User (Soft Delete)
            $user->delete();
        });

        return redirect()->route('admin.users.index')->with('success', 'User dan seluruh datanya berhasil dihapus (Arsip).');
    }
}