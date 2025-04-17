<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

Route::view('profile-admin', 'profile-admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('profile-admin');

require __DIR__.'/auth.php';
