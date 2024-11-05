<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    protected $table = 'diagnosas';

    protected $fillable = [
        'kd_diagnosa',
        'pasien_id',
        'kd_pendaftaran',
        'tanggal_diagnosa',
        'tinggi_badan',
        'berat_badan',
        'tekanan_darah',
        'hasil_pemeriksaan',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'pemeriksaan_lanjutan',
        'catatan',
    ];
    
}
