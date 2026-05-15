<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {

            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ]);

        }

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Artisan en attente
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'artisan' && $user->status === 'pending') {

            Auth::logout();

            return redirect('/artisan/pending');

        }

        /*
        |--------------------------------------------------------------------------
        | Artisan refusé
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'artisan' && $user->status === 'rejected') {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Votre demande a été refusée.',
            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            return redirect('/dashboard');

        }

        /*
        |--------------------------------------------------------------------------
        | Artisan validé
        |--------------------------------------------------------------------------
        */

        return redirect('/dashboard');
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