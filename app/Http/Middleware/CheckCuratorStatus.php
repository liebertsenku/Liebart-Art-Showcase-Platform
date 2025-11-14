<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCuratorStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isCurator() && Auth::user()->isApproved()) {
            return $next($request);
        }
        
        // Jika pending, arahkan ke halaman pending
        if (Auth::check() && Auth::user()->isCurator() && Auth::user()->isPending()) {
             return redirect()->route('curator.pending');
        }

        // Jika bukan curator atau tidak lolos, 403
        abort(403, 'UNAUTHORIZED_ACCESS');
    }
}
