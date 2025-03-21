<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeterReadingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/readings', [MeterReadingController::class, 'index']);
Route::get('/meter-dashboard', [MeterReadingController::class, 'dashboard'])->name('meter.dashboard');

Route::post('/readings', [MeterReadingController::class, 'store']); // ยังไม้ใช้