<?php

use App\Http\Controllers\CurriculumController;
use App\Http\Middlewares\LocaleMiddleware;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['middleware' => ['auth', 'verified', LocaleMiddleware::class]], function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::name('curriculum.')->prefix('curriculum')->group(function () {
        Route::view('/', 'curriculum-grid')->name('grid');
        Route::view('/new', 'curriculum')->name('new');
        Route::view('/view/{curriculumId}', 'curriculum')->name('view');
        Route::view('/view/{curriculumId}/version/{versionId}', 'curriculum')->name('view.version');
        Route::get('/join/{id}', [CurriculumController::class, 'join'])->name('join');

        Route::view('/editor/grid', 'editor')->name('editor.grid');
    });

    Route::view('profile', 'profile')
        ->name('profile');
});

require __DIR__ . '/auth.php';
