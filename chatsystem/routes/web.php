<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
});
