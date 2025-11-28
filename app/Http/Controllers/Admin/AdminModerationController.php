<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModerationReport;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminModerationController extends Controller
{
    public function index()
    {
        // Ambil laporan yang statusnya masih pending
        $reports = ModerationReport::with(['reporter', 'artwork'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.moderation.index', compact('reports'));
    }

    // Approve Report = Laporan Valid = Artwork Dihapus
    public function approve($id)
    {
        $report = ModerationReport::findOrFail($id);
        
        DB::transaction(function () use ($report) {
            // 1. Update Status Report
            $report->update(['status' => 'approved']);

            // 2. Hapus Artwork (Soft Delete)
            if ($report->artwork) {
                $report->artwork->delete();
            }

            // 3. Catat Log
            \DB::table('moderation_logs')->insert([
                'admin_id' => Auth::id(),
                'report_id' => $report->id,
                'action' => 'approve_report',
                'details' => 'Artwork ID ' . $report->artwork_id . ' deleted due to violation: ' . $report->reason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Laporan disetujui. Karya telah dihapus.');
    }

    // Reject Report = Laporan Tidak Valid = Artwork Aman
    public function reject($id)
    {
        $report = ModerationReport::findOrFail($id);

        DB::transaction(function () use ($report) {
            $report->update(['status' => 'rejected']);

            // Catat Log
            \DB::table('moderation_logs')->insert([
                'admin_id' => Auth::id(),
                'report_id' => $report->id,
                'action' => 'reject_report',
                'details' => 'Report dismissed as invalid.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Laporan ditolak. Karya tetap aman.');
    }
}