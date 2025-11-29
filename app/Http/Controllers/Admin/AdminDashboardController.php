<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\CuratorProfile;
use App\Models\ModerationReport;
use App\Models\ChallengeSubmission;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Basic Stats
        $stats = [
            'total_users' => User::count(),
            'total_artworks' => Artwork::count(),
            'total_categories' => Category::count(),
            'total_submissions' => ChallengeSubmission::count(),
            'reports_pending' => ModerationReport::where('status', 'pending')->count(),
            'reports_approved' => ModerationReport::where('status', 'approved')->count(),
            'curators_pending' => CuratorProfile::where('status', 'pending')->count(),
        ];

        // 2. Top Artwork (Most Liked)
        $topArtwork = Artwork::withCount('likes')
            ->orderByDesc('likes_count')
            ->with('user')
            ->first();

        // 3. Most Active Creator (Most Artworks Uploaded)
        $topCreator = User::withCount('artworks')
            ->orderByDesc('artworks_count')
            ->first();

        // 4. Chart Data: Artwork per Category
        $categories = Category::withCount('artworks')->get();
        $chartData = [
            'labels' => $categories->pluck('name'),
            'data' => $categories->pluck('artworks_count'),
        ];

        return view('admin.dashboard', compact('stats', 'topArtwork', 'topCreator', 'chartData'));
    }
}