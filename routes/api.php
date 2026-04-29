<?php

use App\Http\Controllers\Api\HotelPageContentController;
use App\Http\Controllers\Api\HotelPropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/hotel/pages/{page}', [HotelPageContentController::class, 'show']);
Route::get('/hotel/property', [HotelPropertyController::class, 'show']);