<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuratorProfile;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCuratorApprovalController extends Controller
{
    public function index()
    {
        // Ambil semua profil curator, urutkan pending paling atas
        $curators = CuratorProfile::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->paginate(10);

        return view('admin.curators.index', compact('curators'));
    }

    public function approve($id)
    {
        $profile = CuratorProfile::findOrFail($id);
        $user = $profile->user;

        // Update status profil & role user
        $profile->update(['status' => 'approved']);
        $user->update(['role' => 'curator']); // Ubah jadi curator resmi

        // TODO: Kirim Email Notifikasi "Selamat, Anda Diterima!"

        return back()->with('success', 'Curator approved successfully.');
    }

    public function reject($id)
    {
        $profile = CuratorProfile::findOrFail($id);
        
        // Update status profil
        $profile->update(['status' => 'rejected']);
        // Role user tetap 'curator_pending' atau bisa diubah jadi 'member' jika ingin downgrade

        // TODO: Kirim Email Notifikasi "Maaf, aplikasi ditolak."

        return back()->with('success', 'Curator application rejected.');
    }
}