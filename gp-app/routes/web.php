<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadAttachmentController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadConversionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\QcController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
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

    /*
    | Lead pipeline. Access is enforced by LeadPolicy against the leads.*
    | permissions, so editors and QC staff cannot reach any of these.
    | Static segments are declared before /{lead} so they are not swallowed
    | by the wildcard.
    */
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [LeadController::class, 'index'])->name('index');
        Route::get('/create', [LeadController::class, 'create'])->name('create');
        Route::post('/', [LeadController::class, 'store'])->name('store');
        Route::post('/bulk', [LeadController::class, 'bulk'])->name('bulk');

        Route::get('/{lead}', [LeadController::class, 'show'])->name('show');
        Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('edit');
        Route::put('/{lead}', [LeadController::class, 'update'])->name('update');
        Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('destroy');

        Route::patch('/{lead}/status', [LeadController::class, 'updateStatus'])->name('status');
        Route::patch('/{lead}/assign', [LeadController::class, 'assign'])->name('assign');
        Route::post('/{lead}/notes', [LeadController::class, 'storeNote'])->name('notes.store');

        Route::get('/{lead}/attachments/{attachment}', [LeadAttachmentController::class, 'download'])
            ->name('attachments.download');

        // Turning a won lead into a client and their first order.
        Route::get('/{lead}/convert', [LeadConversionController::class, 'create'])->name('convert');
        Route::post('/{lead}/convert', [LeadConversionController::class, 'store'])->name('convert.store');
    });

    /*
    | Production. OrderPolicy gates these on orders.* plus ownership, so a team
    | leader can drive their own orders without holding orders.update. Editors
    | have no order access at all and work from /batches/mine instead.
    */
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/queue', [OrderController::class, 'queue'])->name('queue');

        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('status');
        Route::patch('/{order}/assign', [OrderController::class, 'assign'])->name('assign');
        Route::post('/{order}/notes', [OrderController::class, 'storeNote'])->name('notes.store');
        Route::post('/{order}/batches', [BatchController::class, 'store'])->name('batches.store');
    });

    /*
    | Quality control. Gated on qc.* via QcReviewPolicy, which is deliberately
    | separate from the production permissions so signing work off is not
    | something the production chain can do to itself.
    */
    Route::prefix('qc')->name('qc.')->group(function () {
        Route::get('/', [QcController::class, 'queue'])->name('queue');
        Route::get('/defects', [QcController::class, 'defects'])->name('defects');
        Route::get('/batches/{batch}', [QcController::class, 'show'])->name('show');
        Route::post('/reviews/{review}/approve', [QcController::class, 'approve'])->name('approve');
        Route::post('/reviews/{review}/reject', [QcController::class, 'reject'])->name('reject');
    });

    /*
    | Staff, workload and leave. The directory is gated on staff.view, the
    | workload board on staff.workload.view so team leaders can use it, and
    | leave decisions on LeaveRequestPolicy, which accepts either staff.manage
    | or being the requester's own team leader.
    */
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/workload', [StaffController::class, 'workload'])->name('workload');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('show');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
    });

    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/', [LeaveRequestController::class, 'index'])->name('index');
        Route::post('/', [LeaveRequestController::class, 'store'])->name('store');
        Route::patch('/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('approve');
        Route::patch('/{leaveRequest}/deny', [LeaveRequestController::class, 'deny'])->name('deny');
        Route::patch('/{leaveRequest}/cancel', [LeaveRequestController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });

    Route::prefix('batches')->name('batches.')->group(function () {
        Route::get('/mine', [BatchController::class, 'mine'])->name('mine');
        Route::patch('/{batch}/assign', [BatchController::class, 'assign'])->name('assign');
        Route::patch('/{batch}/status', [BatchController::class, 'updateStatus'])->name('status');
        Route::post('/{batch}/notes', [BatchController::class, 'storeNote'])->name('notes.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
