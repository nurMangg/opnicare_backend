<?php

namespace App\Http\Controllers\Pembayaran;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use App\Models\Obat;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $title;

    public function __construct()
    {
        $this->title = 'Pembayaran';
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->data == 'sudah') {
                $data = Pembayaran::where('status', 'Sudah Bayar')->get();
            } else {
                $data = Pembayaran::all();
            }
            return datatables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit editProduct"><i class="ti ti-eye"></i></a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    
                    ->make(true);
        }

        return view('pages.pembayaran.pembayaran', ['title' => $this->title]);
    }

    public function edit($id) {
        $pembayaran = Pembayaran::find($id);

        $kodeResep = json_decode($pembayaran->resep_obat);
        $kodetindakan = json_decode($pembayaran->tindakan_medis);
        // dd($kodeResep);

        $tindakan_medis = Diagnosa::whereIn('kd_diagnosa', $kodetindakan)->get();
        $obat = Obat::whereIn('medicine_id', $kodeResep)->get();
        
        return response()->json(
            [
                'info' => $pembayaran,
                'status' => true,
                'message' => 'Success',
                'tindakan_medis' => $tindakan_medis,
                'obats' => $obat

            ]
        );
    }

    
}
