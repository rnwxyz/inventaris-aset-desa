<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanBermotorModel extends Model
{
    use HasFactory;

    protected $table = 'kendaraan_bermotor';
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
