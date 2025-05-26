<?php

use App\Http\Controllers\Auth\Bookable\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Bookable\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Bookable\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Bookable\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Bookable\RegisteredUserController;
use App\Http\Controllers\Auth\Bookable\VerifyEmailController;
use App\Http\Controllers\Settings\PasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('bookable')->name('bookable.')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'register'])->name('register.store');
});
Route::middleware('auth:bookable')->name('bookable.')->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    
});
