<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureCuratorIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Cek Login & Role
        if (!$user || !in_array($user->role, ['curator', 'curator_pending'])) {
            abort(403, 'Unauthorized access.');
        }

        // 2. Cek Status Approval
        // Jika belum punya profil atau statusnya bukan approved
        if (!$user->curatorProfile || $user->curatorProfile->status !== 'approved') {
            
            // Redirect ke halaman "Waiting for Approval" atau error page
            return redirect()->route('curator.pending_notice');
        }

        return $next($request);
    }
}