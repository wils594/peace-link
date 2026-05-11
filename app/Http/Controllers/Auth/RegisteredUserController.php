<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'role' => ['required', 'string'],

            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],

            // infos personnelles
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],

            // artisan de paix
            'organization_name' => ['nullable', 'string', 'max:255'],
            'organization_desc' => ['nullable', 'string'],
            'members_count' => ['nullable', 'integer'],
            'website' => ['nullable', 'string'],
            'specialization' => ['nullable', 'string'],
            'motivation' => ['nullable', 'string'],

            // admin
            'admin_secret_key' => ['nullable', 'string'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Vérification clé admin
        |--------------------------------------------------------------------------
        */

        if (
            $request->role === 'admin' &&
            $request->admin_secret_key !== 'PEACELINK_ADMIN_2026'
        ) {
            return back()
                ->withErrors([
                    'admin_secret_key' => 'Clé administrateur invalide.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Statut utilisateur
        |--------------------------------------------------------------------------
        */

        $status = $request->role === 'artisan'
            ? 'pending'
            : 'approved';

        /*
        |--------------------------------------------------------------------------
        | Création utilisateur
        |--------------------------------------------------------------------------
        */

        $user = User::create([

            // infos générales
            'role' => $request->role,
            'status' => $status,

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // infos personnelles
            'phone' => $request->phone,
            'country' => $request->country,
            'city' => $request->city,

            // organisation
            'organization_name' => $request->organization_name,
            'organization_description' => $request->organization_desc,
            'organization_members' => $request->members_count,
            'organization_website' => $request->website,

            // expertise
            'specialization' => $request->specialization,
            'motivation' => $request->motivation,

            // abonnement
            'subscription_status' => 'inactive',
        ]);

        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | Redirections
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'artisan') {

            return redirect('/artisan/pending');

        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}