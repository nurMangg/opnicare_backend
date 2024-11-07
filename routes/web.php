<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Data\DataPoliController;
use App\Http\Controllers\Data\DataRekamMedisController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\layanan\CekPendaftaranController;
use App\Http\Controllers\layanan\PemeriksaanPasienController;
use App\Http\Controllers\layanan\PendaftaranController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\setting\RiwayatController;
use App\Http\Controllers\setting\SettingController;
use App\Http\Controllers\setting\SettingPenggunaController;
use App\Http\Controllers\UserController;
use App\Models\Pendaftaran;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard')->middleware(['auth', 'verified']);

Route::get('/scan', function () {
    return view('scan');
});




Route::get('api/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->middleware('throttle:5,1');

Route::post('api/login', [ApiController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('api.login');


Route::middleware('auth:sanctum')->get('masters/kamars/api/getKamar', [KamarController::class, 'getKamar'])->name('kamars.getkamars');
Route::middleware('auth:sanctum')->get('masters/dokters/api/getDokter', [DokterController::class, 'getDokter'])->name('dokters.getdokter');
Route::middleware('auth:sanctum')->get('masters/obats/api/getObat', [ObatController::class, 'getObat'])->name('obats.getobat');
Route::middleware('auth:sanctum')->post('api/send-data-pendaftaran', [ApiController::class, 'sendDataPendaftaran'])->name('api.senddatapendaftaran');
Route::middleware('auth:sanctum')->get('/api/user', [ApiController::class, 'getUserData']);
Route::middleware('auth:sanctum')->get('api/get-riwayat-pendaftaran/{no_rm}', [ApiController::class, 'getRiwayatPendaftaran'])->name('api.getriwayatpendaftaran');


Route::middleware('auth')->group(function () {
    Route::resource('masters/users', UserController::class);
    Route::resource('masters/pasiens', PasienController::class);

    Route::resource('masters/kamars', KamarController::class);

    Route::resource('masters/dokters', DokterController::class);

    Route::resource('masters/obats', ObatController::class);

    Route::resource('masters/polis', PoliController::class);

    Route::resource('data/datapolis', DataPoliController::class);
    Route::resource('data/datarekammedis', DataRekamMedisController::class);

    Route::resource('setting/settings', SettingController::class);
    Route::resource('setting/setting-pengguna', SettingPenggunaController::class);
    Route::resource('setting/riwayats', RiwayatController::class);

    Route::resource('layanans/pendaftarans', PendaftaranController::class);
    Route::resource('layanans/cek-pendaftarans', CekPendaftaranController::class);
    Route::resource('layanans/pemeriksaan-pasien', PemeriksaanPasienController::class);
    Route::get('layanans/pemeriksaan-pasien/getDataDiagnosis/{pasien_id}', [PemeriksaanPasienController::class, 'getDataDiagnosis'])->name('layanans.pemeriksaan-pasien.getdatadiagnosis');


    Route::POST('layanans/cek-pendaftarans/getInfoPendaftaran', [CekPendaftaranController::class, 'getInfoPendaftaran'])->name('pendaftarans.cekpendaftaran.getinfopendaftaran');

    Route::post('users/reset-password', [UserController::class, 'reset_password'])->name('users.reset_password');
    Route::get('data/datapolis/getDokterByPoliId/{poliId}', [DataPoliController::class, 'getDokterByPoliId'])->name('data.datapolis.getDokterByPoliId');
    Route::get('data/data-pendaftarans', [PendaftaranController::class, 'getPendaftarans'])->name('pendaftarans.listpendaftarans');

});

require __DIR__.'/auth.php';





