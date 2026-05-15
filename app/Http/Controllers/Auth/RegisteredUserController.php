<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Afficher la page d'inscription
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Inscription artisan de paix
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
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

            // organisation
            'organization_name' => ['nullable', 'string', 'max:255'],
            'organization_desc' => ['nullable', 'string'],
            'members_count' => ['nullable', 'integer'],
            'website' => ['nullable', 'string'],

            // expertise
            'specialization' => ['nullable', 'string'],
            'motivation' => ['nullable', 'string'],
        ]);

        $user = User::create([

            // système
            'role' => 'artisan',
            'status' => 'pending',
            'subscription_status' => 'inactive',

            // utilisateur
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // personnelles
            'phone' => $request->phone,
            'country' => $request->country,
            'city' => $request->city,

            // organisation
            'organization_name' => $request->organization_name,
            'organization_description' => $request->organization_desc,
            'organization_members' => $request->members_count,
            'organization_website' => $request->website,

            // profil
            'specialization' => $request->specialization,
            'motivation' => $request->motivation,
        ]);

        event(new Registered($user));

        return redirect('/')
            ->with('success', 'Votre demande a été envoyée avec succès.');
    }
}