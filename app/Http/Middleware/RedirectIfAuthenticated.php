<?php

namespace App\Http\Middleware;

// Perhatikan: 'use App\Providers\RouteServiceProvider;' SUDAH DIHAPUS
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                // === LOGIKA REDIRECT PINTAR (BARU) ===
                $user = Auth::user();

                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }

                if ($user->isCurator()) {
                    if ($user->isApproved()) {
                        return redirect()->route('curator.dashboard');
                    } else {
                        return redirect()->route('curator.pending');
                    }
                }
                
                // Default untuk Member (ke /dashboard)
                return redirect('/dashboard');
                // ===================================
            }
        }

        return $next($request);
    }
}