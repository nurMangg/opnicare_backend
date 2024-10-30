<?php

namespace App\Http\Controllers\layanan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PasienController;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    protected $form;
    protected $form_daftar;

    protected $title;

    public function __construct()
    {
        $this->title = 'Pendaftaran Pasien';

        $this->form = array(
            array(
                'label' => 'Nomor Rekam Medis',
                'field' => 'no_rm',
                'type' => 'text',
                'placeholder' => '',
                'width' => 3,
            ),
            array(
                'label' => 'NIK',
                'field' => 'nik',
                'width' => 3,
                'type' => 'number',
                'placeholder' => '',
                'required' => true,
                'disabled' => true,
            ),
            array(
                'label' => 'Nama Pasien',
                'field' => 'nama_pasien',
                'type' => 'text',
                'width' => 3,
                'placeholder' => '',
                'required' => true,
                'disabled' => true,


            ),
            array(
                'label' => 'Alamat',
                'field' => 'alamat',
                'type' => 'text',
                'width' => 3,
                'placeholder' => '',
                'required' => true,
                'disabled' => true,


            ),
            array(
                'label' => 'Email',
                'field' => 'email',
                'type' => 'email',
                'width' => 3,
                'placeholder' => '',
                'disabled' => true,

            ),
            array(
                'label' => 'NO. Hp (62xxx-xxxx-xxxx)',
                'field' => 'no_hp',
                'width' => 3,
                'type' => 'number',
                'placeholder' => '',
                'disabled' => true,

            ),
            array(
                'label' => 'Tanggal Lahir',
                'field' => 'tanggal_lahir',
                'type' => 'date',
                'placeholder' => '',
                'width' => 3,
                'required' => true,
                'disabled' => true,


            ),
            array(
                'label' => 'Jenis Kelamin (L/P)',
                'field' => 'jk',
                'type' => 'text',
                'width' => 3,
                'placeholder' => '',
                'required' => true,
                'disabled' => true,


            ),
        );

        $this->form_daftar = array(
            array(
                'label' => 'Poli',
                'field' => 'poli_id',
                'type' => 'select',
                'placeholder' => 'Pilih Poli',
                'width' => 4,
                'options' => Poli::pluck('nama_poli', 'id')->toArray(),
                'required' => true
            ),
            array(
                'label' => 'Dokter',
                'field' => 'dokter_id',
                'type' => 'select',
                'placeholder' => 'Pilih Dokter',
                'width' => 4,
                'options' => Dokter::pluck('nama', 'id')->toArray(),
                'required' => true
            ),
            array(
                'label' => 'Tanggal Daftar',
                'field' => 'tanggal_daftar',
                'type' => 'date',
                'placeholder' => '',
                'width' => 4,
                'required' => true,
            ),
            array(
                'label' => 'Keluhan',
                'field' => 'keluhan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan keluhan',
                'width' => 12,
                'required' => true,
            ),
        );
    }

    public function index(Request $request)
    {
        return view('pages.layanans.pendaftarans', ['form' => $this->form, 'form_daftar' => $this->form_daftar ,'title' => $this->title]);
    }

    public function show($id)
    {
        $user = Pasien::where('no_rm', $id)->first(); 

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

}
