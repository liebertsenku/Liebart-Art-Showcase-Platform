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
        if ($artwork->user_id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menyukai karya sendiri.');
        }

        $user = Auth::user();
        if ($user->hasLiked($artwork)) {
            $user->likes()->detach($artwork->id);
            $message = 'Like dihapus.';
        } else {
            $user->likes()->attach($artwork->id);
            $message = 'Artwork disukai!';
        }

        return back()->with('success', $message);
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

        ModerationReport::create([
            'reporter_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Laporan dikirim ke Admin.');
    }
}
