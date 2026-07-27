<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Role-aware entry point: redirects to the dashboard for the user's role.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Each dashboard is reachable by its own role, plus admin for oversight.
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::get('/dashboard/marketing', [DashboardController::class, 'marketing'])
        ->middleware('role:admin|marketing_manager')
        ->name('dashboard.marketing');

    Route::get('/dashboard/production', [DashboardController::class, 'production'])
        ->middleware('role:admin|production_manager')
        ->name('dashboard.production');

    Route::get('/dashboard/team', [DashboardController::class, 'team'])
        ->middleware('role:admin|team_leader')
        ->name('dashboard.team');

    Route::get('/dashboard/editor', [DashboardController::class, 'editor'])
        ->middleware('role:admin|editor')
        ->name('dashboard.editor');

    Route::get('/dashboard/qc', [DashboardController::class, 'qc'])
        ->middleware('role:admin|qc_staff')
        ->name('dashboard.qc');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
