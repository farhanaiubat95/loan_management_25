<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LoanController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {

    // Role-based dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard.admin');
//     })->name('dashboard');

//     Route::view('/users', 'admin.users')->name('users');
//     Route::view('/loans', 'admin.loans')->name('loans');
//     Route::view('/settings', 'admin.settings')->name('settings');
// });

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('dashboard');

        // USERS
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // LOANS (Corrected)
        Route::get('/loans', [LoanController::class, 'index'])->name('loans');

        Route::get('/loans/{id}/edit', [LoanController::class, 'edit'])->name('loans.edit');
        Route::put('/loans/{id}', [LoanController::class, 'update'])->name('loans.update');
        Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
        Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');

        Route::post('/loans/{id}/status', [LoanController::class, 'updateStatus'])->name('loans.status');

        Route::get('/loans/{id}/schedule', [LoanController::class, 'schedule'])->name('admin.loans.schedule');

        Route::post('/installment/{id}/pay', [LoanController::class, 'markInstallmentPaid'])->name('admin.installment.pay');


        // SETTINGS
        Route::view('/settings', 'admin.settings')->name('settings');
    });



require __DIR__.'/auth.php';
