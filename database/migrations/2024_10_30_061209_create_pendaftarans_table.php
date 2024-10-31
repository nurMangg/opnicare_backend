<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pendaftaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_pendaftaran');
            $table->string('pasien_id');
            $table->string('dokter_id');
            $table->string('poli_id');
            $table->date('tanggal_daftar');
            $table->mediumText('keluhan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pendaftaran');
    }
};
