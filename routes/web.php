<?php

use App\Http\Controllers\AdminController\AdminUserController;
use App\Http\Controllers\AdminController\AdminDashboardController;
use App\Http\Controllers\AdminController\LoanPaymentController;
use App\Http\Controllers\AdminController\LoanTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController\UserDashboardController;
use Illuminate\Support\Facades\Mail;




Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// AUTH ROUTES

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// USER ROUTES

Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('/loans', [UserDashboardController::class, 'store'])->name('loans.store');

    });


// MANAGER ROUTES

Route::middleware(['auth', 'manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', fn () => view('dashboard.manager'))->name('dashboard');
    });


// ADMIN ROUTES
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // USERS
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])   ->name('users.update');

        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/status', [AdminUserController::class, 'updateStatus'])->name('users.status');

        // OTP
        Route::post('/users/send-otp', [AdminUserController::class, 'sendOtp'])->name('users.sendOtp');
        Route::post('/users/verify-otp', [AdminUserController::class, 'verifyOtpAndCreate'])->name('users.verifyOtp');

        // LOANS
        Route::get('/loans', [LoanController::class, 'index'])->name('loans');
        Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
        Route::put('/loans/{id}', [LoanController::class, 'update'])->name('loans.update');
        Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');
        Route::post('/loans/{loan}/status',  [AdminDashboardController::class, 'updateStatus'])->name('admin.loan.updateStatus');
        Route::get('/loans/{id}/schedule', [LoanController::class, 'schedule'])
            ->name('loans.schedule');

        Route::post('/installment/{id}/pay', [LoanController::class, 'markInstallmentPaid'])
            ->name('installment.pay');

        // LOAN TYPES
        Route::resource('loan-types', LoanTypeController::class);
        Route::post('/loan-types', [LoanTypeController::class, 'store'])->name('loan-types.store');
        Route::patch('loan-types/{loan_type}/toggle-status', [LoanTypeController::class, 'toggleStatus'])->name('loan-types.toggle-status');
        Route::put('loan-types/{loan_type}', [LoanTypeController::class, 'update'])->name('loan-types.update');
        Route::delete('loan-types/{loan_type}', [LoanTypeController::class, 'destroy'])->name('loan-types.destroy');   

        // LOAN PAYMENT
        Route::get('/payment', [LoanPaymentController::class, 'index'])->name('payment');

        Route::get('/loans/{loan}/payment', [LoanPaymentController::class, 'show'])
            ->name('loan.payment');

        // LOAN DISBURSEMENT
        Route::post('/loans/{loan}/disburse', 
            [LoanPaymentController::class, 'disburse']
        )->name('loan.disburse');
    });

require __DIR__.'/auth.php';
