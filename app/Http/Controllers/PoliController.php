<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoliController extends Controller
{
    protected $form;
    protected $title;

    public function __construct()
    {
        $this->title = 'Poli';

        $this->form = array(
            array(
                'label' => 'Nama Poli',
                'field' => 'nama_poli',
                'type' => 'text',
                'placeholder' => '',
                'width' => 12,
                'required' => true
            ),
            array(
                'label' => 'Deskripsi',
                'field' => 'deskripsi',
                'width' => 12,
                'type' => 'text',
                'placeholder' => '',
                'required' => false
            ),
        );
    }

    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Poli::all();
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

        return view('pages.polis', ['form' => $this->form, 'title' => $this->title]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_poli' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $poli = Poli::updateOrCreate(
            ['id' => $request->id],
            [
                'nama_poli' => $request->nama_poli,
                'deskripsi' => $request->deskripsi,
            ]
        );

        return response()->json(['success' => 'Poli berhasil disimpan.']);
    }

    public function edit($id)
    {
        $poli = Poli::find($id);
        return response()->json($poli);
    }

    // Fungsi untuk mengupdate data yang telah diedit
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_poli' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $poli = Poli::find($id);
        $poli->update(
            [
                'nama_poli' => $request->nama_poli,
                'deskripsi' => $request->deskripsi,
            ]
        );

        return response()->json(['success' => 'Poli updated successfully.']);
    }

    // Fungsi untuk menghapus data
    public function destroy($id)
    {
        Poli::find($id)->delete();
        return response()->json(['success' => 'Poli deleted successfully.']);
    }
}
