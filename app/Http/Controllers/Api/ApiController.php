<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataPoli;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        // Attempt to log the user in using manual authentication
        $user = User::where('email', $request->email)->first();
        $pasien = Pasien::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication passed, generate token
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'no_rm' => $pasien->no_rm,
            ], 200);
        }

        // Authentication failed
        return response()->json([
            'error' => 'Invalid credentials'
        ], 401);
    }

    public function getUserData(Request $request)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        $pasien = Pasien::where('email', $user->email)->first();

        return response()->json($pasien);
    }

    public function generateUniqueCode($id, $poli_id, $tanggal) {
        $dokterPart = substr($id, -3);

        $poli = Poli::find($poli_id);
        
        $namaPoli = $poli->kd_poli;
        $date = date('Ymd', strtotime($tanggal));
        

        $uniqueCode = $namaPoli . $date . $dokterPart;

        return $uniqueCode;
    }

    public function sendDataPendaftaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'dokter_id' => 'required',
            'pasien_id' => 'required',
            'keluhan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $dokter = DataPoli::where('dokter_id', $request->dokter_id)->first();
        // dd($dokter);

        $Pasien = Pasien::where('no_rm', $request->pasien_id)->first();
        $user_id = User::where('email', $Pasien->email)->first();

        $pendaftaranCount = Pendaftaran::whereDate('tanggal_daftar', $request->date)
        ->where('poli_id', $dokter->poli_id)
        ->count();
        $dokterKD = str_pad($pendaftaranCount + 1, 4, '0', STR_PAD_LEFT);
        
        $pendaftaran = Pendaftaran::create([
            'no_pendaftaran' => $this->generateUniqueCode($dokterKD, $dokter->poli_id, $request->tanggal_daftar),
            'pasien_id' => $request->pasien_id,
            'poli_id' => $dokter->poli_id,
            'dokter_id' => $request->dokter_id,
            'tanggal_daftar' => $request->date,
            'keluhan' => $request->keluhan,
            'status' => 'Terdaftar'
    ]);

        $this->storeRiwayat($user_id->id, "pendaftaran", "INSERT", json_encode($pendaftaran));

        return response()->json(['success' => 'Pendaftaran berhasil disimpan.']);
    }

    public function getRiwayatPendaftaran($no_rm)
    {
        $riwayat = Pendaftaran::where('pasien_id', $no_rm)
            ->leftjoin('mspoli', 'data_pendaftaran.poli_id', '=', 'mspoli.id')
            ->leftjoin('msdokter', 'data_pendaftaran.dokter_id', '=', 'msdokter.id')
            ->select('data_pendaftaran.*', 'mspoli.nama_poli', 'msdokter.nama')
            ->orderBy('data_pendaftaran.created_at', 'desc')->get();

        return response()->json($riwayat);
    }
}
