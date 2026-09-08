<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Settings\SecurityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'));
    Route::get('/customers', [CustomersController::class, 'index'])->name('customers');
    Route::get('/settings/profile', fn () => Inertia::render('settings/Profile'))->name('settings.profile');
    Route::get('/settings/security', SecurityController::class)->name('settings.security');
});

Route::get('notify', function () {
    toast('Hello world');
});
