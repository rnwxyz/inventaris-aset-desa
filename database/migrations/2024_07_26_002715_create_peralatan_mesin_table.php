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
        Schema::create('peralatan_mesin', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kode_barang')->unique(indexName: 'kode_barang_unique');
            $table->string('nup');
            $table->string('merk');
            $table->year('tahun_perolehan');
            $table->decimal('nilai_perolehan', 20, 2);
            $table->boolean('b');
            $table->boolean('rr');
            $table->boolean('rb');
            $table->string('keterangan')->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peralatan_mesin');
    }
};
