<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    protected $form;
    protected $title;

    public function __construct()
    {
        $this->title = 'Dokter';

        $this->form = array(
            array(
                'label' => 'Kode Dokter',
                'field' => 'kd_dokter',
                'type' => 'text',
                'placeholder' => '',
                'width' => 6,
                'disabled' => true,
            ),
            array(
                'label' => 'NIK',
                'field' => 'nik',
                'width' => 6,
                'type' => 'number',
                'placeholder' => 'Masukkan NIK',
                'required' => true
            ),
            array(
                'label' => 'Nama Dokter',
                'field' => 'nama',
                'type' => 'text',
                'width' => 6,
                'placeholder' => 'Masukkan Nama',
                'required' => true

            ),
            array(
                'label' => 'Alamat',
                'field' => 'alamat',
                'type' => 'textarea',
                'width' => 6,
                'placeholder' => 'Masukkan Alamat',
                'required' => true

            ),
            array(
                'label' => 'Email',
                'field' => 'email',
                'type' => 'email',
                'width' => 6,
                'placeholder' => 'Masukkan Email',
                'required' => true
            ),
            array(
                'label' => 'NO. Hp (62xxx-xxxx-xxxx)',
                'field' => 'no_hp',
                'width' => 6,
                'type' => 'number',
                'placeholder' => 'Masukkan NO. Hp',
            ),
            array(
                'label' => 'Tanggal Lahir',
                'field' => 'tanggal_lahir',
                'type' => 'date',
                'placeholder' => '',
                'width' => 6,
                'required' => true

            ),
            array(
                'label' => 'Jenis Kelamin (L/P)',
                'field' => 'jk',
                'type' => 'text',
                'width' => 6,
                'placeholder' => '',
                'required' => true

            ),
            array(
                'label' => 'Pekerjaan',
                'field' => 'pekerjaan',
                'type' => 'text',
                'width' => 6,
                'placeholder' => '',
            ),
            array(
                'label' => 'Kewarganegaraan',
                'field' => 'kewarganegaraan',
                'type' => 'text',
                'width' => 6,
                'placeholder' => '',
            ),
            array(
                'label' => 'Agama',
                'field' => 'agama',
                'width' => 6,
                'type' => 'text',
                'placeholder' => '',
            ),
            array(
                'label' => 'Pendidikan',
                'field' => 'pendidikan',
                'width' => 6,
                'type' => 'text',
                'placeholder' => '',
            ),
            array(
                'label' => 'Spesialisasi',
                'field' => 'spesialisasi',
                'width' => 6,
                'type' => 'text',
                'placeholder' => '',
                'required' => true
            ),
            array(
                'label' => 'Status',
                'field' => 'status',
                'type' => 'select',
                'width' => 6,
                'placeholder' => 'Masukan Status',
                'required' => true,
                'options' => [
                    'aktif' => 'Aktif',
                    'tidak' => 'Tidak Aktif'
                ]

            ),
        );
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Dokter::all();
            return datatables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-outline-primary btn-sm editProduct"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-outline-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i> Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('pages.dokters', ['form' => $this->form, 'title' => $this->title]);
    }

    public function generateUniqueCode($id) {
        $date = date('ym');
        $dokterPart = substr($id, -3);

        $uniqueCode = "DR" . $date . $dokterPart;

        return $uniqueCode;
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
            'jk' => 'required',
            'spesialisasi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dokterCount = Dokter::whereYear('created_at', date('Y'))
                                ->whereMonth('created_at', date('m'))
                                ->count();
        $dokterKD = str_pad($dokterCount + 1, 3, '0', STR_PAD_LEFT);

        $user = Dokter::updateOrCreate(
            ['id' => $request->id],
            ['nama' => $request->nama,
             'nik' => $request->nik, 
             'alamat' => $request->alamat, 
             'email' => $request->email, 
             'no_hp' => $request->no_hp, 
             'tanggal_lahir' => $request->tanggal_lahir,
             'jk' => $request->jk, 
             'pekerjaan' => $request->pekerjaan, 
             'kewarganegaraan' => $request->kewarganegaraan, 
             'agama' => $request->agama, 
             'pendidikan' => $request->pendidikan, 
             'spesialisasi' => $request->spesialisasi, 
             'status' => $request->status, 
             'kd_dokter' => $this->generateUniqueCode($dokterKD)
             ]
        );

        return response()->json(['success' => 'User berhasil disimpan.']);
    }

    public function edit($id)
    {
        $user = Dokter::find($id);
        return response()->json($user);
    }

    // Fungsi untuk mengupdate data yang telah diedit
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'tanggal_lahir' => 'required',
            'jk' => 'required',
            'spesialisasi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Dokter::find($id);
        $user->update(
            [
                'nama' => $request->nama, 
                'alamat' => $request->alamat, 
                'email' => $request->email, 
                'no_hp' => $request->no_hp, 
                'tanggal_lahir' => $request->tanggal_lahir,
                'jk' => $request->jk, 
                'pekerjaan' => $request->pekerjaan, 
                'kewarganegaraan' => $request->kewarganegaraan, 
                'agama' => $request->agama, 
                'pendidikan' => $request->pendidikan, 
                'spesialisasi' => $request->spesialisasi, 
                'status' => $request->status, 
            ]
    );

        return response()->json(['success' => 'User updated successfully.']);
    }

    // Fungsi untuk menghapus data
    public function destroy($id)
    {
        Dokter::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
}
