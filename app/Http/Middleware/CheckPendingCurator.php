<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPendingCurator
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya izinkan akses jika user adalah curator DAN statusnya pending
        if (Auth::check() && Auth::user()->isCurator() && Auth::user()->isPending()) {
            return $next($request);
        }
        
        // Jika sudah di-approve, tendang ke dashboard-nya
        if (Auth::check() && Auth::user()->isCurator() && Auth::user()->isApproved()) {
             return redirect()->route('curator.dashboard');
        }

        // Jika bukan curator, tendang ke home
        return redirect('/');
    }
}
