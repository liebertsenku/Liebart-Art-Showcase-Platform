<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeSubmissionController extends Controller
{
    public function create(Challenge $challenge)
    {
        // Validasi Deadline
        if (now()->greaterThan($challenge->deadline)) {
            return redirect()->route('challenges.index')->with('error', 'Challenge sudah berakhir.');
        }

        // Ambil artwork milik user untuk dipilih
        $myArtworks = Auth::user()->artworks()->latest()->get();

        return view('member.challenges.submit', compact('challenge', 'myArtworks'));
    }

    public function store(Request $request, Challenge $challenge)
    {
        // 1. Validasi Input
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
        ]);

        // 2. Validasi Kepemilikan Artwork
        $artwork = Auth::user()->artworks()->find($request->artwork_id);
        if (!$artwork) {
            return back()->with('error', 'Artwork tidak valid atau bukan milik Anda.');
        }

        // 3. Validasi Deadline
        if (now()->greaterThan($challenge->deadline)) {
            return back()->with('error', 'Maaf, challenge sudah ditutup.');
        }

        // 4. Validasi Unique Submission (Sudah di-handle database unique constraint, tapi kita cek manual agar rapi)
        $exists = ChallengeSubmission::where('challenge_id', $challenge->id)
                    ->where('user_id', Auth::id())
                    ->exists();
        
        if ($exists) {
            return back()->with('error', 'Anda sudah mengirimkan karya untuk challenge ini.');
        }

        // 5. Simpan
        ChallengeSubmission::create([
            'challenge_id' => $challenge->id,
            'artwork_id' => $artwork->id,
            'user_id' => Auth::id(),
            'submitted_at' => now(),
        ]);

        return redirect()->route('challenges.show', $challenge)->with('success', 'Karya berhasil di-submit!');
    }
}