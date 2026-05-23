<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PAGE SIGNALEMENT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('report');
    }

    /*
    |--------------------------------------------------------------------------
    | ENREGISTRER UN SIGNALEMENT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'type' => 'required|string|max:255',

            'description' => 'required|string',

            'danger_level' => 'required|integer|min:1|max:100',

            'zone' => 'required|string|max:255',

            'district' => 'required|string|max:255',

            'latitude' => 'required|numeric',

            'longitude' => 'required|numeric',

        ]);

        Report::create([

            'type' => $request->type,

            'description' => $request->description,

            'danger_level' => $request->danger_level,

            'zone' => $request->zone,

            'district' => $request->district,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'anonymous' => true,

            'status' => 'pending',

        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Signalement envoyé avec succès.'
            );
    }

public function adminSignals()
{
    $reports = Report::latest()->get();

    $totalReports = $reports->count();

    $pendingCount = Report::where('status', 'pending')->count();

    $resolvedCount = Report::where('status', 'resolved')->count();

    return view('signals', compact(
        'reports',
        'totalReports',
        'pendingCount',
        'resolvedCount'
    ));
}

public function hotspots()
{
    $reports = Report::latest()->get();

    return view('hotspots', compact('reports'));
}

}