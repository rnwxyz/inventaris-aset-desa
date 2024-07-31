<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeralatanMesinModel extends Model
{
    use HasFactory;

    protected $table = 'peralatan_mesin';
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
}
