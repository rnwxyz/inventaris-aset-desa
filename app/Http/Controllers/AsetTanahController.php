<?php

namespace App\Http\Controllers;

use App\Exports\AsetTanahExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AsetTanahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AsetTanahController extends Controller
{
    public function index()
    {
        // get all data from peralatan_mesin table
        $asetTanah = AsetTanahModel::all();

        return view('aset-tanah', compact('asetTanah'));
    }

    public function store(Request $request)
    {
        // mapping request data to model
        $req = $request->all();

        // create new data
        $data_input = [
            'jenis_barang' => $req['jenis_barang'],
            'identitas_barang' => $req['identitas_barang'],
            'apbd' => $req['apbd'],
            'perolehan_lain_yang_sah' => $req['perolehan_lain_yang_sah'],
            'aset_atau_kekayaan_asli_desa' => $req['aset_atau_kekayaan_asli_desa'],
            'tanggal_bulan_tahun_perolehan' => $req['tanggal_bulan_tahun_perolehan'],
            'harga_nilai_perolehan' => $req['harga_nilai_perolehan'],
            'perkiraan_harga_nilai_sekarang' => $req['perkiraan_harga_nilai_sekarang'],
            'keterangan' => $req['keterangan']
        ];

        $res = AsetTanahModel::create($data_input);
        // check if data is successfully created
        if (!$res) {
            return Redirect::route('aset-tanah')->with('error', 'Gagal menambahkan data');
        }

        return Redirect::route('aset-tanah');
    }

    public function delete($id)
    {
        AsetTanahModel::destroy($id);

        return Redirect::route('aset-tanah');
    }

    public function update(Request $request, $id)
    {
        $asetTanah = AsetTanahModel::find($id);
        // mapping request data to model
        $req = $request->all();

        // create new data
        $data_update = [
            'jenis_barang' => $req['jenis_barang'],
            'identitas_barang' => $req['identitas_barang'],
            'apbd' => $req['apbd'],
            'perolehan_lain_yang_sah' => $req['perolehan_lain_yang_sah'],
            'aset_atau_kekayaan_asli_desa' => $req['aset_atau_kekayaan_asli_desa'],
            'tanggal_bulan_tahun_perolehan' => $req['tanggal_bulan_tahun_perolehan'],
            'harga_nilai_perolehan' => $req['harga_nilai_perolehan'],
            'perkiraan_harga_nilai_sekarang' => $req['perkiraan_harga_nilai_sekarang'],
            'keterangan' => $req['keterangan']
        ];

        $res = $asetTanah->update($data_update);
        // check if data is successfully updated
        if (!$res) {
            return Redirect::route('aset-tanah')->with('error', 'Gagal mengubah data');
        }

        return Redirect::route('aset-tanah');
    }

    public function export()
    {
        // Pengelola
        // bulan bahasa indonesia
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        // tanggal sekarang
        $tanggal = date('d') . '_' . strtolower($bulan[date('n') - 1]) . '_' . date('Y');
        return Excel::download(new AsetTanahExport(), 'laporan_aset_tanah_' . $tanggal . '.xlsx');
    }
}
