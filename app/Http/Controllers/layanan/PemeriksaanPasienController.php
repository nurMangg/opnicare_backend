<?php

namespace App\Http\Controllers\layanan;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemeriksaanPasienController extends Controller
{
    protected $form_daftar;

    public function __construct() {
        $this->form_daftar = array(
            array(
                'label' => 'Pasien ID',
                'field' => 'pasien_id',
                'type' => 'hidden',
                'placeholder' => '',
                'width' => 0,
                'hidden' => true
            ),
            array(
                'label' => 'No. Pendaftaran',
                'field' => 'no_pendaftaran',
                'placeholder' => '',
                'type' => 'hidden',
                'width' => 0,
                'hidden' => true
            ),
            
            array(
                'label' => 'Hasil Pemeriksaan',
                'field' => 'hasil_pemeriksaan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan hasil pemeriksaan',
                'width' => 6,
                'required' => true
            ),
            array(
                'label' => 'Diagnosa',
                'field' => 'diagnosa',
                'type' => 'textarea',
                'placeholder' => 'Masukkan diagnosa',
                'width' => 6,
                'required' => true

            ),
            array(
                'label' => 'Tindakan',
                'field' => 'tindakan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan tindakan',
                'width' => 6,
                'required' => true

            ),
            array(
                'label' => 'Resep Obat',
                'field' => 'resep_obat',
                'type' => 'textarea',
                'placeholder' => 'Masukkan resep obat',
                'width' => 6,

            ),
            array(
                'label' => 'Pemeriksaan Lanjutan',
                'field' => 'pemeriksaan_lanjutan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan pemeriksaan lanjutan',
                'width' => 6,
            ),
            array(
                'label' => 'Catatan',
                'field' => 'catatan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan catatan',
                'width' => 6,
            ),
        );
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pendaftaran::where('tanggal_daftar', date('Y-m-d'))
                            ->where('status', 'Dalam Antrian')
                            ->get();
            return datatables()::of($data)
                    ->addIndexColumn()
                    ->editColumn('poli_id', function($row) {
                        return Poli::find($row->poli_id)->nama_poli;
                    })
                    ->editColumn('dokter_id', function($row) {
                        return Dokter::find($row->dokter_id)->nama;
                    })
                    ->addColumn('nama_pasien', function($row) {
                        return Pasien::where('no_rm', $row->pasien_id)->first()->nama_pasien;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('pages.layanans.pendaftaran.pemeriksaanpasien', ['title' => "Data Pemeriksaan Pasien"]);
    }

    public function getDataDiagnosis($pasien_id, Request $request)
    {
        if ($request->ajax()) {
        
            $data = Diagnosa::where('pasien_id', $pasien_id)
                            ->get();
            return datatables()::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
                    ->make(true);
        }
        
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::where('no_pendaftaran', $id)
            ->leftjoin('mspasien', 'data_pendaftaran.pasien_id', '=', 'mspasien.no_rm')
            ->leftjoin('msdokter', 'data_pendaftaran.dokter_id', '=', 'msdokter.id')
            ->leftjoin('mspoli', 'data_pendaftaran.poli_id', '=', 'mspoli.id')
            ->first();
        return view('pages.layanans.pendaftaran.actionpemeriksaanpasien', ['pendaftaran' => $pendaftaran, 'title' => "Data Pemeriksaan Pasien", 'form_daftar' => $this->form_daftar]);
    }

    public function generateUniqueCode($id) {
        $date = date('ym');
        $pelangganPart = substr($id, -3);


        $uniqueCode = "RM" . $date . $pelangganPart;

        return $uniqueCode;
    }


public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'pasien_id' => 'required',

        'hasil_pemeriksaan' => 'required',
        'diagnosa' => 'required',
        'tindakan' => 'required',
        'resep_obat' => 'nullable',
        'pemeriksaan_lanjutan' => 'nullable',
        'catatan' => 'nullable',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $diagnosaCount = Pasien::whereYear('created_at', date('Y'))
    ->whereMonth('created_at', date('m'))
    ->count();

    $diagnosaRM = str_pad($diagnosaCount + 1, 3, '0', STR_PAD_LEFT);
    // dd($request->all());

    $diagnosa = Diagnosa::updateOrCreate(
        ['id' => $request->id],
        [
            'pasien_id' => $request->pasien_id,
            'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'resep_obat' => $request->resep_obat,
            'pemeriksaan_lanjutan' => $request->pemeriksaan_lanjutan,
            'catatan' => $request->catatan,
            'tanggal_diagnosa' => date('Y-m-d'),
            'kd_diagnosa' => $this->generateUniqueCode($diagnosaRM),
            'kd_pendaftaran' => $request->no_pendaftaran,
        ]
    );

    $this->storeRiwayat(Auth::user()->id, "diagnosas", "INSERT", json_encode($diagnosa));


    return response()->json(['success' => 'Data pemeriksaan berhasil disimpan.']);
}
}
