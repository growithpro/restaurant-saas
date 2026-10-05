<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'auth.login')->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::livewire('/restaurant/setup', 'restaurant.setup')
    ->middleware('auth')
    ->name('restaurant.setup');


    Route::livewire('/branches', 'branches')
    ->middleware('auth')
    ->name('branches');