<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\TimeSlotsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['role:admin'],'prefix'=>'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::group(['middleware' => ['role:doctor'],'prefix'=>'doctor'], function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
});


Route::group(['middleware' => ['role:doctor'],'prefix'=>'doctor'], function () {
    Route::get('/time-slots/create', [TimeSlotsController::class, 'create'])->name('time-slots.create');
    Route::post('/time-slots', [TimeSlotsController::class, 'store'])->name('time-slots.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
