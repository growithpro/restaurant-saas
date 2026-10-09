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

Route::livewire('/pos', 'pos')
    ->middleware('auth')
    ->name('pos');

Route::livewire('/orders', 'orders')
    ->middleware('auth')
    ->name('orders');

Route::livewire('/kitchen', 'kitchen')
    ->middleware('auth')
    ->name('kitchen');

Route::livewire('/billing', 'billing')
    ->middleware('auth')
    ->name('billing');

Route::livewire('/inventory', 'inventory')
    ->middleware('auth')
    ->name('inventory');

Route::livewire('/recipes', 'recipes')
    ->middleware('auth')
    ->name('recipes');

Route::livewire('/reports', 'reports')
    ->middleware('auth')
    ->name('reports');
