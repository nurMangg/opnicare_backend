<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $table = 'msriwayat';

    protected $fillable = [
        'user_id',
        'table',
        'aksi',
        'keterangan',
    ];
}
