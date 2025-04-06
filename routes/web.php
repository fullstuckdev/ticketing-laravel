<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Tickets
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');

    // Members
    Route::resource('members', MemberController::class);

    // Transactions
    Route::resource('transactions', TransactionController::class);
}); 