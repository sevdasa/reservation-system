<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Bookable\DashboardController as BookableDashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TimeSlotsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::group(['middleware' => ['auth:admin'],'prefix'=>'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::group(['middleware' => ['auth:bookable'],'prefix'=>'bookable','as'=>'bookable.'], function () {
    Route::get('/dashboard', [BookableDashboardController::class, 'index'])->name('dashboard');
    Route::get('/time-slots/create', [TimeSlotsController::class, 'create'])->name('time-slots.create');
    Route::post('/time-slots/store', [TimeSlotsController::class, 'store'])->name('time-slots.store');
});


Route::group(['middleware' => ['auth'],'prefix'=>'bookable','as'=>'bookable.'], function () {
    Route::get('/time-slots', [TimeSlotsController::class, 'index'])->name('time-slots.index');
    
});
Route::group(['middleware' => ['auth'],'prefix'=>'reservation','as'=>'reservation.'], function () {
    Route::get('/confirm', [ReservationController::class, 'confirm'])->name('confirm');
    Route::post('/confirm', [ReservationController::class, 'store'])->name('store');
    Route::get('/', [ReservationController::class, 'index'])->name('index');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/BookableAuth.php';
