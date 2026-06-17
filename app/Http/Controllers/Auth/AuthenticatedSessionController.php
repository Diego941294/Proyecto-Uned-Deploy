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
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->hasRole('Super Administrador')) {
        return redirect()->intended(route('super-admin.dashboard'));
    }

    if ($user->hasRole('Administrador')) {
        return redirect()->intended(route('administrador.dashboard'));
    }

    if ($user->hasRole('Supervisor')) {
        return redirect()->intended(route('supervisor.dashboard'));
    }

    Auth::logout();

    return redirect()
        ->route('login')
        ->with('error', 'El usuario no tiene un rol asignado.');
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
