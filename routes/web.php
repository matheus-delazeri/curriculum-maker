<?php

use App\Http\Controllers\CurriculumController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->name('curriculum.')
    ->prefix('curriculum')
    ->group(function () {
        Route::view('/', 'curriculum-grid')->name('grid');
        Route::view('/new', 'curriculum')->name('new');
        Route::view('/view/{curriculumId}', 'curriculum')->name('view');
        Route::view('/view/{curriculumId}/version/{versionId}', 'curriculum')->name('view.version');
        Route::get('/join/{id}', [CurriculumController::class, 'join'])->name('join');

        Route::view('/editor/grid', 'editor')->name('editor.grid');
    });

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
