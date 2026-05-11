<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingArtisans = User::where('role', 'artisan')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('dashboard', compact('pendingArtisans'));
    }

    public function approve($id)
{
    $artisan = User::findOrFail($id);

    $artisan->status = 'approved';

    $artisan->save();

    return redirect()->back()
        ->with('success', 'Artisan approuvé avec succès.');
}

public function reject($id)
{
    $artisan = User::findOrFail($id);

    $artisan->status = 'rejected';

    $artisan->save();

    return redirect()->back()
        ->with('success', 'Artisan refusé.');
}
}