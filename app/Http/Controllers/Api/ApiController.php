<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataPoli;
use App\Models\DetailTransaksiObat;
use App\Models\Keluhan;
use App\Models\Keranjang;
use App\Models\KeranjangObat;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use App\Models\TransaksiObat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


        $user = User::where('email', $request->email)->first();
        $pasien = Pasien::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'no_rm' => $pasien->no_rm,
                'nama' => $pasien->nama_pasien
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

        $dateOnly = date('Y-m-d', strtotime($request->date));

        $dokter = DataPoli::where('dokter_id', $request->dokter_id)->first();
        // dd($dokter);


        $Pasien = Pasien::where('no_rm', $request->pasien_id)->first();
        $user_id = User::where('email', $Pasien->email)->first();

        if (Pendaftaran::where('pasien_id', $request->pasien_id)
            ->where('poli_id', $dokter->poli_id)
            ->where('tanggal_daftar', $dateOnly)
            ->exists()) {
            return response()->json(['error' => 'Pasien sudah terdaftar di poli ini untuk tanggal yang dipilih'], 421);
        }
        $pendaftaranCount = Pendaftaran::where('tanggal_daftar', $dateOnly)
        ->where('poli_id', $dokter->poli_id)
        ->count();
        $dokterKD = str_pad($pendaftaranCount + 1, 4, '0', STR_PAD_LEFT);
        
        $pendaftaran = Pendaftaran::create([
            'no_pendaftaran' => $this->generateUniqueCode($dokterKD, $dokter->poli_id, $dateOnly),
            'pasien_id' => $request->pasien_id,
            'poli_id' => $dokter->poli_id,
            'dokter_id' => $request->dokter_id,
            'tanggal_daftar' => Date($request->date),
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    
    public function refreshToken(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token tidak ditemukan'], 401);
        }
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 401);
        }
        $newToken = $user->createToken('MyApp')->plainTextToken;
        return response()->json(['token' => $newToken]);
    }

    
    public function sendKeluhan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required',
            'keluhan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move('images/keluhan', $imageName);

        $keluhan = Keluhan::create([
            'user_id' => $user->id,
            'foto' => $imageName,
            'keluhan' => $request->keluhan
        ]);
        return response()->json(['success' => 'Keluhan berhasil disimpan.']);
    }


    public function tambahObat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pasienId' => 'required',
            'obatId' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $cart = Keranjang::updateOrCreate([
            'pasienId' => $request->pasienId,
            'obatId' => $request->obatId
        ], [
            'jumlah' => $request->jumlah
        ]);


        return response()->json(['message' => 'Product added to cart successfully!', 'cart' => $cart]);
    }

    public function getDataKeranjang($no_rm) {

        $keranjang = Keranjang::where('pasienId', $no_rm)
        ->leftJoin('msobat', 'data_keranjangobat.obatId', '=', 'msobat.medicine_id')
        ->get();
        return response()->json($keranjang);
    }

    public function generateUniqueCodeTRX($id) {
        $trxId = substr($id, -3);
        $date = date('Ymd', strtotime(Carbon::now()));
        

        $uniqueCode = "TRX" . $date . $trxId;

        return $uniqueCode;
    }

    public function transaksiObat(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'pasienId' => 'required',
            'total' => 'required',
            'obat.*.obatId' => 'required', 
            'obat.*.jumlah' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $trxCount = TransaksiObat::count();
        $trxKD = str_pad($trxCount + 1, 4, '0', STR_PAD_LEFT);

        $kodeTRX = $this->generateUniqueCodeTRX($trxKD);

        foreach ($request->obat as $obat) {
            try {
                DetailTransaksiObat::create([
                    'transaksi_id' => $kodeTRX,
                    'obatId' => $obat['obatId'],
                    'jumlah' => $obat['jumlah']
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 422);
            }
        }
        

        $transaksi = TransaksiObat::create([
            'transaksi_id' => $kodeTRX,
            'pasienId' => $request->pasienId,
            'total' => $request->total,
            'tanggal_transaksi' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => 'Belum Bayar'
        ]);

        //hapus dari keranjang
        Keranjang::where('pasienId', $request->pasienId)->delete();

        return response()->json(['message' => 'Transaksi obat berhasil!', 'transaksi' => $transaksi]);
    }

}
