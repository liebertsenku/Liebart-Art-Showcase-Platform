<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authenticated request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // === LOGIKA REDIRECT KUSTOM ANDA ===
        $user = $request->user();

        if ($user->isAdmin()) {
            // Admin SELALU ke Admin Dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->isCurator()) {
            if ($user->isApproved()) {
                // Curator (Approved) ke Curator Dashboard
                return redirect()->intended(route('curator.dashboard'));
            } else {
                // Curator (Pending) SELALU ke halaman Pending
                return redirect()->route('curator.pending');
            }
        }
        
        // Default untuk Member
        return redirect()->intended('/dashboard');
        // ===================================
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}