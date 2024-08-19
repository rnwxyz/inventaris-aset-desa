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
        Schema::create('aset_tanah', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_barang');
            $table->string('identitas_barang');
            $table->string('apbd');
            $table->string('perolehan_lain_yang_sah');
            $table->string('aset_atau_kekayaan_asli_desa');
            $table->string('tanggal_bulan_tahun_perolehan');
            $table->string('harga_nilai_perolehan');
            $table->string('perkiraan_harga_nilai_sekarang');
            $table->string('keterangan')->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_tanah');
    }
};
