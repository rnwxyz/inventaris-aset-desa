<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeralatanMesinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required',
            'kode_barang' => 'required|unique:peralatan_mesin',
            'nup' => 'required',
            'merk' => 'required',
            'tahun_perolehan' => 'required',
            'nilai_perolehan' => 'required',
            'b' => 'required',
            'rr' => 'required',
            'rb' => 'required',
            'keterangan' => 'nullable'
        ];
    }
}
