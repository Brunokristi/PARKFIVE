<?php

use App\Http\Controllers\Admin\HotelManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [HotelManagementController::class, 'index'])->name('admin.dashboard');
    Route::post('/settings', [HotelManagementController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/pages', [HotelManagementController::class, 'updatePages'])->name('admin.pages.update');
    Route::post('/property', [HotelManagementController::class, 'updateProperty'])->name('admin.property.update');
});

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');