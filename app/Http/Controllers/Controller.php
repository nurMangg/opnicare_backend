<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;

abstract class Controller
{
    public function storeRiwayat($userId, $table, $action, $description)
    {
        // Validasi input jika diperlukan
        $data = [
            'user_id' => $userId,
            'table' => $table,
            'aksi' => $action,
            'keterangan' => $description,
        ];

        // Simpan ke tabel riwayat
        Riwayat::create($data);
    }
}
