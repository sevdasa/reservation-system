<?php

use App\Http\Controllers\Auth\GitHubController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/auth/github', action: [GitHubController::class,'redirect'])->name('github.redirect');

Route::get('/auth/github/callback', action: [GitHubController::class,'callback'])->name('github.callback');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
