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
        Schema::create('diagnosas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd_diagnosa');
            $table->string('kd_pendaftaran');
            $table->string('pasien_id');
            $table->date('tanggal_diagnosa');
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('hasil_pemeriksaan')->nullable();
            $table->string('diagnosa')->nullable();
            $table->string('tindakan')->nullable();
            $table->string('resep_obat')->nullable();
            $table->string('pemeriksaan_lanjutan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosas');
    }
};
