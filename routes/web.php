<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route utama
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');

// Reset password routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'sendResetPasswordLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset')->middleware('guest');
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');
// Dashboard dan absensi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AttendanceController::class, 'index'])->name('dashboard');

    // Ganti kata sandi
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

    Route::prefix('attendance')->group(function () {
        Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
        Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    });

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/attendances', [AttendanceController::class, 'adminIndex'])->name('admin.attendances');
    });
});