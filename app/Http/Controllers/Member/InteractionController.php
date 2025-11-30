<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\ModerationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    // --- LIKE SYSTEM ---
    public function toggleLike(Artwork $artwork)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        // 2. Gunakan Toggle (Ini mendeteksi otomatis: Ada -> Hapus, Tidak Ada -> Tambah)
        // toggle() mengembalikan array ['attached' => [], 'detached' => []]
        $changes = $user->likes()->toggle($artwork->id);

        // 3. Cek Status Sebenarnya dari Hasil Toggle
        // Jika ada ID di array 'attached', berarti BARU SAJA DI-LIKE.
        // Jika tidak, berarti baru saja di-UNLIKE.
        $isLikedNow = count($changes['attached']) > 0;

        // 4. Hitung Ulang Jumlah Like Real-time
        $totalLikes = $artwork->likes()->count();

        return response()->json([
            'status' => 'success',
            'liked' => $isLikedNow, // Status akurat dari DB (true/false)
            'count' => $totalLikes  // Jumlah akurat dari DB
        ]);
    }
    
    // --- FAVORITE SYSTEM ---
    public function toggleFavorite(Artwork $artwork)
    {
        $user = Auth::user();
        if ($user->hasFavorited($artwork)) {
            $user->favorites()->detach($artwork->id);
            $message = 'Dihapus dari favorit.';
        } else {
            $user->favorites()->attach($artwork->id);
            $message = 'Disimpan ke favorit.';
        }

        return back()->with('success', $message);
    }

    // --- COMMENT SYSTEM ---
    public function storeComment(Request $request, Artwork $artwork)
    {
        $request->validate(['body' => 'required|string|max:500']);

        Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar ditambahkan.');
    }

    public function destroyComment(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $comment->delete();
        return back()->with('success', 'Komentar dihapus.');
    }

    // --- REPORT SYSTEM ---
    public function storeReport(Request $request, Artwork $artwork)
    {
        if ($artwork->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa melaporkan karya sendiri.');
        }

        $request->validate(['reason' => 'required|string']);

        // Gunakan relasi reports() dari model Artwork langsung
        $artwork->reports()->create([
            'reporter_id' => Auth::id(),
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Laporan artwork dikirim ke Admin.');
    }

    public function reportComment(Request $request, Comment $comment)
    {
        if ($comment->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa melaporkan komentar sendiri.');
        }

        $request->validate(['reason' => 'required|string']);

        // Simpan laporan untuk komentar
        $comment->reports()->create([
            'reporter_id' => Auth::id(),
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Laporan komentar dikirim ke Admin.');
    }
}
