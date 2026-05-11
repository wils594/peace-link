<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::post('/admin/artisans/{id}/approve',
    [DashboardController::class, 'approve'])
    ->name('admin.artisans.approve');

Route::post('/admin/artisans/{id}/reject',
    [DashboardController::class, 'reject'])
    ->name('admin.artisans.reject');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/artisan/pending', function () {

    return view('artisan.pending');

});

Route::post('/posts/store', [PostController::class, 'store'])
    ->middleware('auth')
    ->name('posts.store');

    Route::post('/artisan/register', [App\Http\Controllers\Auth\RegisterController::class, 'artisanRegister'])->name('artisan.register');

});

require __DIR__.'/auth.php';