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
        // Ambil report pending, eager load relasi polimorfik
        $reports = ModerationReport::with(['reporter', 'reportable'])
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
            $report->update(['status' => 'approved']);

            // Hapus Konten Berdasarkan Tipe
            if ($report->reportable) {
                
                // Jika yang dilaporkan adalah ARTWORK
                if ($report->reportable_type === 'App\Models\Artwork') {
                    $report->reportable->delete(); // Soft Delete Artwork
                    $details = 'Artwork deleted: ' . $report->reportable->title;
                }
                // Jika yang dilaporkan adalah COMMENT
                elseif ($report->reportable_type === 'App\Models\Comment') {
                    $report->reportable->delete(); // Delete Comment (biasanya hard delete atau soft delete jika disetting)
                    $details = 'Comment deleted: ' . \Illuminate\Support\Str::limit($report->reportable->body, 20);
                }
            }

            // Catat Log
            \DB::table('moderation_logs')->insert([
                'admin_id' => Auth::id(),
                'report_id' => $report->id,
                'action' => 'approve_report',
                'details' => $details ?? 'Content already deleted',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Laporan disetujui. Konten telah dihapus.');
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