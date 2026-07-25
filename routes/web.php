<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuAccessController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('menus', MenuController::class);
    Route::resource('users', UserController::class);

    Route::prefix('menu-access')->name('menuaccess.')->group(function () {
        Route::get('/', [MenuAccessController::class, 'index'])->name('index');
        Route::post('/', [MenuAccessController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
