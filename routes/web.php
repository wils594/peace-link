<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Models\Report;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',
        [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN - VALIDATION ARTISANS
    |--------------------------------------------------------------------------
    */

    Route::post('/admin/artisans/{id}/approve',
        [DashboardController::class, 'approve'])
        ->name('admin.artisans.approve');

    Route::post('/admin/artisans/{id}/reject',
        [DashboardController::class, 'reject'])
        ->name('admin.artisans.reject');

    /*
    |--------------------------------------------------------------------------
    | POSTS
    |--------------------------------------------------------------------------
    */

    Route::post('/posts/store',
        [PostController::class, 'store'])
        ->name('posts.store');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',
        [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ARTISAN
|--------------------------------------------------------------------------
*/

Route::get('/artisan/pending', function () {

    return view('artisan.pending');

})->name('artisan.pending');

/*
|--------------------------------------------------------------------------
| PAGES DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/signals', function () {

    return view('signals');

})->name('admin.signals');

Route::get('/hotspots', function () {

    return view('hotspots');

})->name('admin.hotspots');

Route::get('/artisans', function () {

    return view('artisans');

})->name('admin.artisans');

Route::get('/statistics', function () {

    return view('statistics');

})->name('admin.statistics');

Route::get('/reports', function () {

    return view('reports');

})->name('admin.reports');

Route::get('/admins', function () {

    return view('admins');

})->name('admin.admins');

Route::get('/settings', function () {

    return view('settings');

})->name('admin.settings');

/*
|--------------------------------------------------------------------------
| ARTISAN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/artisan/dashboard', function () {

    return view('artisan.dashboard');

})->middleware('auth')->name('artisan.dashboard');

Route::get('/report',
    [ReportController::class, 'create'])
    ->name('report.create');

Route::post('/report',
    [ReportController::class, 'store'])
    ->name('report.store');

    Route::get('/admin/api/recent-reports', function () {

    $reports = Report::latest()
        ->take(10)
        ->get();

    return response()->json([
        'success' => true,
        'reports' => $reports
    ]);

});

require __DIR__.'/auth.php';