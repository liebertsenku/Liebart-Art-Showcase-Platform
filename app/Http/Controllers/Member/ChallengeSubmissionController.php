<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeSubmission;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeSubmissionController extends Controller
{
    /**
     * Proses penyimpanan submission dari member.
     */
    public function store(Request $request, $challengeId)
    {
        $challenge = Challenge::findOrFail($challengeId);

        // 1. Validasi Waktu (PERBAIKAN DI SINI)
        // Menggunakan 'end_date' bukan 'deadline'
        if (now()->greaterThan($challenge->end_date)) {
            return back()->with('error', 'Maaf, challenge sudah ditutup (Deadline terlewat).');
        }

        // Alternatif: Gunakan computed status jika sudah ada di model
        // if ($challenge->computed_status !== 'active') { ... }

        // 2. Validasi Input
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
        ]);

        // 3. Validasi Kepemilikan Artwork
        $artwork = Artwork::where('id', $request->artwork_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$artwork) {
            return back()->with('error', 'Artwork tidak valid atau bukan milik Anda.');
        }

        // 4. Validasi Double Submit (Mencegah submit 2x)
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

        return back()->with('success', 'Karya berhasil di-submit! Semoga menang.');
    }

    /**
     * Membatalkan submission.
     */
    public function destroy($id)
    {
        $submission = ChallengeSubmission::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Hanya bisa hapus jika challenge belum berakhir
        // PERBAIKAN DI SINI JUGA (end_date)
        if (now()->greaterThan($submission->challenge->end_date)) {
            return back()->with('error', 'Tidak bisa menghapus submission dari challenge yang sudah berakhir.');
        }

        $submission->delete();

        return back()->with('success', 'Submission dibatalkan.');
    }
}