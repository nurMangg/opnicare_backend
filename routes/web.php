<?php

use App\Http\Controllers\PasienController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::resource('users', UserController::class);
Route::resource('pasiens', PasienController::class);