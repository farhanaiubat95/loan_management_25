<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;

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

        // FIXED USERS ROUTE
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        Route::view('/loans', 'admin.loans')->name('loans');
        Route::view('/settings', 'admin.settings')->name('settings');
    });


require __DIR__.'/auth.php';
