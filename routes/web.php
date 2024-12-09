<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\InvoiceController;


Route::get('/', function () {
    return view('homepage');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__.'/auth.php';

Route::get('/login', function () {
    return view('auth.custom-login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index');
Route::post('/rooms/store', [RoomsController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{id}/edit', [RoomsController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{id}', [RoomsController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{id}', [RoomsController::class, 'destroy'])->name('rooms.destroy');
Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');


Route::get('/customers', [UserController::class, 'index'])->name('users.index');
Route::get('/customers/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');



Route::get('/generate-qrcode', [QRCodeController::class, 'showForm']);
Route::post('/generate-qrcode', [QRCodeController::class, 'generateQRCode']);


Route::get('/payments', [InvoiceController::class, 'showForm'])->name('admin.payments');
Route::post('/invoice', [InvoiceController::class, 'generateInvoice'])->name('generate.invoice');
