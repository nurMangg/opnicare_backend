<?php

use App\Http\Controllers\Data\DataPoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\layanan\PendaftaranController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::resource('masters/users', UserController::class);
Route::resource('masters/pasiens', PasienController::class);
Route::resource('masters/kamars', KamarController::class);
Route::resource('masters/dokters', DokterController::class);
Route::resource('masters/obats', ObatController::class);
Route::resource('masters/polis', PoliController::class);

Route::resource('data/datapolis', DataPoliController::class);



Route::resource('layanans/pendaftarans', PendaftaranController::class);




Route::post('users/reset-password', [UserController::class, 'reset_password'])->name('users.reset_password');
Route::get('data/datapolis/getDokterByPoliId/{poliId}', [DataPoliController::class, 'getDokterByPoliId'])->name('data.datapolis.getDokterByPoliId');
