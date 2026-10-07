<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'auth.login')->name('login');

Route::livewire('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::livewire('/restaurant/setup', 'restaurant.setup')
    ->middleware('auth')
    ->name('restaurant.setup');

Route::livewire('/branches', 'branches')
    ->middleware('auth')
    ->name('branches');

Route::livewire('/tables', 'tables')
    ->middleware('auth')
    ->name('tables');

Route::livewire('/categories', 'categories')
    ->middleware('auth')
    ->name('categories');

Route::livewire('/menu-items', 'menu-items')
    ->middleware('auth')
    ->name('menu-items');

Route::livewire('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
