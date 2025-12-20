<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
