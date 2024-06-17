<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('curriculum', 'curriculum')
    ->middleware(['auth', 'verified'])
    ->name('curriculum');

Route::get('/curriculum/create', \App\Livewire\Forms\CurriculumForm::class)
    ->middleware(['auth', 'verified'])
    ->name('curriculum.create');

Route::get('/curriculum/edit/{curriculumId}', \App\Livewire\Forms\CurriculumForm::class)
    ->middleware(['auth', 'verified'])
    ->name('curriculum.edit');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
