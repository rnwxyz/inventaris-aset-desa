<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangunanLainnyaModel extends Model
{
    use HasFactory;

    protected $table = 'bangunan_lainnya';
    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'nup',
        'merk',
        'tahun_perolehan',
        'nilai_perolehan',
        'b',
        'rr',
        'rb',
        'keterangan'
    ];

    // add row number to the data
    public function getRowNumber()
    {
        return $this->row_number;
    }
}
