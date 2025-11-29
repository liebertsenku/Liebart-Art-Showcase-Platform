<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengeWinner;
use App\Models\ChallengeSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CuratorChallengeController extends Controller
{
    // 1. LIST CHALLENGE
    public function index()
    {
        $challenges = Challenge::where('curator_id', Auth::id())
            ->withCount('submissions')
            ->latest()
            ->paginate(9);
            
        return view('curator.challenges.index', compact('challenges'));
    }

    // 2. FORM CREATE
    public function create()
    {
        return view('curator.challenges.create');
    }

    // 3. STORE (SIMPAN)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:30',
            'rules' => 'required|string',
            'prizes' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('banner_image')->store('challenges', 'public');

        Challenge::create([
            'curator_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(100, 999),
            'description' => $request->description,
            'rules' => $request->rules,
            'prizes' => $request->prizes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'banner_image' => $path,
            'status' => 'active', // Default active
        ]);

        return redirect()->route('curator.challenges.index')->with('success', 'Challenge created successfully!');
    }

    // 4. SHOW (DETAIL + SUBMISSIONS)
   public function show(Challenge $challenge)
    {
        // Pastikan hanya pemilik yang bisa lihat menu kurasi
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Ambil submission dengan data artwork & user
        $submissions = $challenge->submissions()
            ->with(['artwork', 'user'])
            ->withCount('artwork') // Opsional jika butuh count likes artwork
            ->latest()
            ->paginate(12);

        // Ambil data pemenang yang sudah dipilih (jika ada)
        // KeyBy position agar mudah diakses di view (contoh: $winners['1'])
        $winners = $challenge->winners()
            ->with('submission.artwork.user')
            ->get()
            ->keyBy('position');

        return view('curator.challenges.show', compact('challenge', 'submissions', 'winners'));
    }


    // 5. EDIT FORM
    public function edit(Challenge $challenge)
    {
        $this->authorizeAccess($challenge);
        return view('curator.challenges.edit', compact('challenge'));
    }

    // 6. UPDATE
    public function update(Request $request, Challenge $challenge)
    {
        $this->authorizeAccess($challenge);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|min:30',
            'rules' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('banner_image');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('banner_image')) {
            if ($challenge->banner_image) {
                Storage::disk('public')->delete($challenge->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('challenges', 'public');
        }

        $challenge->update($data);

        return redirect()->route('curator.challenges.show', $challenge->id)->with('success', 'Challenge updated.');
    }

    // 7. DESTROY
    public function destroy(Challenge $challenge)
    {
        $this->authorizeAccess($challenge);
        if ($challenge->banner_image) {
            Storage::disk('public')->delete($challenge->banner_image);
        }
        $challenge->delete();
        return redirect()->route('curator.challenges.index')->with('success', 'Challenge deleted.');
    }

    // 8. SELECT WINNER
    public function selectWinner(Request $request, Challenge $challenge)
    {
        // 1. Validasi Pemilik
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // 2. Validasi Input
        $request->validate([
            'submission_id' => 'required|exists:challenge_submissions,id',
            'position' => 'required|in:1,2,3',
        ]);

        // 3. Validasi Submission milik Challenge ini
        $submission = ChallengeSubmission::where('id', $request->submission_id)
            ->where('challenge_id', $challenge->id)
            ->firstOrFail();

        // 4. Simpan / Update Pemenang
        // Logic: Jika posisi 1 sudah ada, update dengan submission baru.
        ChallengeWinner::updateOrCreate(
            [
                'challenge_id' => $challenge->id,
                'position' => $request->position
            ],
            [
                'submission_id' => $submission->id
            ]
        );

        // 5. Opsi Tambahan: Jika Juara 1, 2, 3 sudah lengkap, otomatis tutup challenge?
        // (Opsional, tapi diminta di prompt)
        $winnerCount = ChallengeWinner::where('challenge_id', $challenge->id)->count();
        if ($winnerCount >= 3) {
            // Kita bisa memaksa tanggal berakhir jadi hari ini agar statusnya jadi 'ended'
            // Atau cukup biarkan tanggal aslinya.
            // Di sini kita biarkan saja, karena status 'ended' biasanya based on date.
            // Tapi kita beri notifikasi.
            return back()->with('success', 'Winner selected! All podiums are filled.');
        }

        return back()->with('success', 'Winner for position #' . $request->position . ' selected successfully.');
    }

    // Helper: Pastikan hanya curator pemilik yg bisa akses
    private function authorizeAccess(Challenge $challenge)
    {
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this challenge.');
        }
    }


    public function removeWinner(Challenge $challenge, $position)
    {
        if ($challenge->curator_id !== Auth::id()) {
            abort(403);
        }

        ChallengeWinner::where('challenge_id', $challenge->id)
            ->where('position', $position)
            ->delete();

        return back()->with('success', 'Winner removed from position #' . $position);
    }

    public function finish(Challenge $challenge)
    {
        // 1. Validasi Pemilik
        if ($challenge->curator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // 2. Cek apakah pemenang sudah dipilih (Minimal Juara 1)
        $hasWinner = $challenge->winners()->exists();
        
        if (!$hasWinner) {
            return back()->with('error', 'Please select at least one winner before finishing the challenge.');
        }

        // 3. Update Status & Tanggal
        // Kita ubah end_date jadi sekarang agar logika 'computed_status' otomatis jadi 'ended'
        // Kita juga set kolom status di DB jadi 'ended' untuk kepastian.
        $challenge->update([
            'status' => 'ended',
            'end_date' => now(), 
        ]);

        return back()->with('success', 'Challenge finished! Winners are now visible to the public.');
    }
}