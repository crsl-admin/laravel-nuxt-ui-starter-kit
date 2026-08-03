<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'));
    Route::get('/customers', fn () => Inertia::render('Customers'))->name('customers');
});

Route::get('notify', function () {
    Inertia::flash('toast', ['message' => 'Hello world']);
});
