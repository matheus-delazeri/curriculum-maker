<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('curriculum', 'curriculum-grid')
    ->middleware(['auth', 'verified'])
    ->name('curriculum');

Route::view('/curriculum/create', 'curriculum')
    ->middleware(['auth', 'verified'])
    ->name('curriculum.create');

Route::view('/curriculum/view/{curriculumId}', 'curriculum')
    ->middleware(['auth', 'verified'])
    ->name('curriculum.view');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
