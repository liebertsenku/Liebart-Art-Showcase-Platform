<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicChallengeController extends Controller
{
    /**
     * Menampilkan daftar semua challenge.
     */
    public function index()
    {
        // Tampilkan challenge yang tidak 'draft', urutkan dari yang Ongoing, lalu Upcoming, lalu Ended
        $challenges = Challenge::where('status', '!=', 'draft')
            ->orderByRaw("FIELD(status, 'ongoing', 'upcoming', 'ended')")
            ->latest()
            ->paginate(9);

        return view('public.challenges.index', compact('challenges'));
    }

    /**
     * Menampilkan detail challenge & galeri partisipan.
     */
    public function show($slug)
    {
        $challenge = Challenge::where('slug', $slug)
            ->with(['curator', 'winners.submission.artwork.user']) // Eager load
            ->firstOrFail();

        // Ambil submission peserta (Pagination)
        $submissions = $challenge->submissions()
            ->with(['artwork.user', 'user'])
            ->latest()
            ->paginate(12);

        // Cek apakah user yang login sudah submit?
        $hasSubmitted = false;
        $mySubmission = null;
        
        if (Auth::check()) {
            $mySubmission = ChallengeSubmission::where('challenge_id', $challenge->id)
                ->where('user_id', Auth::id())
                ->with('artwork')
                ->first();
            
            if ($mySubmission) {
                $hasSubmitted = true;
            }
        }

        // Ambil list artwork user sendiri untuk di-submit (hanya jika belum submit & challenge aktif)
        $myArtworks = [];
        if (Auth::check() && !$hasSubmitted && $challenge->computed_status == 'active') {
            $myArtworks = Auth::user()->artworks()->latest()->get();
        }

        return view('public.challenges.show', compact('challenge', 'submissions', 'hasSubmitted', 'mySubmission', 'myArtworks'));
    }
}   