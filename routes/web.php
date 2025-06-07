<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Bookable\DashboardController as BookableDashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Broadcast;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::group(['middleware' => ['auth:bookable'], 'prefix' => 'bookable', 'as' => 'bookable.'], function () {
    Route::get('/dashboard', [BookableDashboardController::class, 'index'])->name('dashboard');
    Route::get('/time-slots/create', [TimeSlotController::class, 'create'])->name('time-slots.create');
    Route::post('/time-slots/store', [TimeSlotController::class, 'store'])->name('time-slots.store');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'bookable', 'as' => 'bookable.'], function () {
    Route::get('/time-slots', [TimeSlotController::class, 'index'])->name('time-slots.index');

});
Route::group(['middleware' => ['auth'], 'prefix' => 'reservation', 'as' => 'reservation.'], function () {
    Route::get('/confirm', [ReservationController::class, 'confirm'])->name('confirm');
    Route::post('/confirm', [ReservationController::class, 'store'])->name('store');
    Route::get('/{id?}', [ReservationController::class, 'index'])->name('index');

});

Route::group(['middleware' => ['auth:web'],'as'=>'user.'], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});
// Route::group(['middleware' => ['auth'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/BookableAuth.php';
