<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Artisans en attente
        |--------------------------------------------------------------------------
        */

        $pendingArtisans = User::where('type', 'artisan')
            ->where('status', 'pending')
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Nombre d’artisans actifs
        |--------------------------------------------------------------------------
        */

        $activeArtisans = User::where('type', 'artisan')
            ->where('status', 'approved')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Statistiques
        |--------------------------------------------------------------------------
        */

        $totalReports = 0;
        $resolvedReports = 0;
        $pendingReports = 0;
        $resolutionRate = 0;

        /*
        |--------------------------------------------------------------------------
        | Données vides
        |--------------------------------------------------------------------------
        */

        $recentReports = [];
        $regionsData = [];

        return view('dashboard', compact(
            'pendingArtisans',
            'activeArtisans',
            'totalReports',
            'resolvedReports',
            'pendingReports',
            'resolutionRate',
            'recentReports',
            'regionsData'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | APPROUVER ARTISAN
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $artisan = User::findOrFail($id);

        $artisan->status = 'approved';

        $artisan->save();

        return redirect()
            ->back()
            ->with('success', 'Artisan approuvé avec succès.');
    }

    /*
    |--------------------------------------------------------------------------
    | REFUSER ARTISAN
    |--------------------------------------------------------------------------
    */

    public function reject($id)
    {
        $artisan = User::findOrFail($id);

        $artisan->status = 'rejected';

        $artisan->save();

        return redirect()
            ->back()
            ->with('success', 'Artisan refusé.');
    }
}