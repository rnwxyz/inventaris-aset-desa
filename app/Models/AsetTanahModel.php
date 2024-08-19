<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetTanahModel extends Model
{
    use HasFactory;

    protected $table = 'aset_tanah';
    protected $fillable = [
        'jenis_barang',
        'identitas_barang',
        'apbd',
        'perolehan_lain_yang_sah',
        'aset_atau_kekayaan_asli_desa',
        'tanggal_bulan_tahun_perolehan',
        'harga_nilai_perolehan',
        'perkiraan_harga_nilai_sekarang',
        'keterangan'
    ];

    // add row number to the data
    public function getRowNumber()
    {
        return $this->row_number;
    }
}
