<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeSubmission;
// Hapus Request dan Storage karena tidak dipakai lagi untuk create/update
// use Illuminate\Http\Request; 
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage;

class AdminChallengeController extends Controller
{
    // 1. LIST CHALLENGE (Tetap Ada)
    public function index()
    {
        $challenges = Challenge::withCount('submissions')->latest()->paginate(10);
        return view('admin.challenges.index', compact('challenges'));
    }

    // 2. DETAIL CHALLENGE (Tetap Ada)
    public function show(Challenge $challenge)
    {
        $submissions = $challenge->submissions()
            ->with(['artwork.user', 'artwork'])
            ->get()
            ->map(function ($submission) {
                $submission->artwork->loadCount('likes'); 
                return $submission;
            });

        return view('admin.challenges.show', compact('challenge', 'submissions'));
    }

    // 3. HAPUS CHALLENGE (Tetap Ada)
    public function destroy(Challenge $challenge)
    {
        // Opsional: Hapus gambar cover jika ada
        // if ($challenge->cover_image) {
        //    \Illuminate\Support\Facades\Storage::disk('public')->delete($challenge->cover_image);
        // }

        $challenge->delete();
        return back()->with('success', 'Challenge deleted.');
    }

    // 4. HAPUS SUBMISSION PESERTA (Tetap Ada - Fitur Moderasi)
    public function destroySubmission($submissionId)
    {
        $submission = ChallengeSubmission::findOrFail($submissionId);
        $submission->delete();
        return back()->with('success', 'Submission removed from challenge.');
    }

    // === METHOD YANG DIHAPUS ===
    // create(), store(), edit(), update() SUDAH DIHAPUS
}