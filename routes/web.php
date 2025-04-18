<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin-dashboard');

Route::view('profile-admin', 'profile-admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('profile-admin');

Route::view('product', 'product')
    ->middleware(['auth', 'verified'])
    ->name('product');

Route::view('category', 'category')
    ->middleware(['auth', 'verified'])
    ->name('category');

Route::view('review', 'review')
    ->middleware(['auth', 'verified'])
    ->name('review');

Route::view('order', 'order')
    ->middleware(['auth', 'verified'])
    ->name('order');

Route::view('promotion', 'promotion')
    ->middleware(['auth', 'verified'])
    ->name('promotion');

Route::view('report', 'report')
    ->middleware(['auth', 'verified'])
    ->name('report');    
    
require __DIR__.'/auth.php';
