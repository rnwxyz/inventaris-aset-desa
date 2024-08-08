<?php

namespace App\Http\Controllers;

use App\Exports\BangunanLainnyaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BangunanLainnyaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BangunanLainnyaController extends Controller
{
    public function index()
    {
        // get all data from peralatan_mesin table
        $bangunanLainnya = BangunanLainnyaModel::all();

        return view('bangunan-lainnya', compact('bangunanLainnya'));
    }

    public function store(Request $request)
    {
        // mapping request data to model
        $req = $request->all();

        // check duplicate kode_barang
        $isExist = BangunanLainnyaModel::where('kode_barang', $req['kode_barang'])->first();
        if ($isExist) {
            return Redirect::route('bangunan-lainnya')->with('error', 'Barang dengan kode ' . $req['kode_barang'] . ' sudah ada');
        }

        // check kode
        $b = false;
        if (!empty($req['kode_barang_b']) && $req['kode_barang_b'] == 'B') {
            $b = true;
        }

        $rr = false;
        if (!empty($req['kode_barang_rr']) && $req['kode_barang_rr'] == 'RR') {
            $rr = true;
        }

        $rb = false;
        if (!empty($req['kode_barang_rb']) && $req['kode_barang_rb'] == 'RB') {
            $rb = true;
        }

        // create new data
        $data_input = [
            "nama_barang" => $req['nama_barang'],
            "kode_barang" => $req['kode_barang'],
            "nup" => $req['nup'],
            "merk" => $req['merk'],
            "tahun_perolehan" => $req['tahun_perolehan'],
            "nilai_perolehan" => $req['nilai_perolehan'],
            "b" => $b,
            "rr" => $rr,
            "rb" => $rb,
            "keterangan" => $req['keterangan']
        ];

        $res = BangunanLainnyaModel::create($data_input);
        // check if data is successfully created
        if (!$res) {
            return Redirect::route('bangunan-lainnya')->with('error', 'Gagal menambahkan data');
        }

        return Redirect::route('bangunan-lainnya');
    }

    public function delete($id)
    {
        BangunanLainnyaModel::destroy($id);

        return Redirect::route('bangunan-lainnya');
    }

    public function update(Request $request, $id)
    {
        $BangunanLainnya = BangunanLainnyaModel::find($id);
        // mapping request data to model
        $req = $request->all();

        // check duplicate kode_barang except current data
        $isExist = BangunanLainnyaModel::where('kode_barang', $req['kode_barang'])->where('id', '!=', $id)->first();
        if ($isExist) {
            return Redirect::route('bangunan-lainnya')->with('error', 'Barang dengan kode ' . $req['kode_barang'] . ' sudah ada');
        }

        // check kode
        $b = false;
        if (!empty($req['kode_barang_b']) && $req['kode_barang_b'] == 'B') {
            $b = true;
        }

        $rr = false;
        if (!empty($req['kode_barang_rr']) && $req['kode_barang_rr'] == 'RR') {
            $rr = true;
        }

        $rb = false;
        if (!empty($req['kode_barang_rb']) && $req['kode_barang_rb'] == 'RB') {
            $rb = true;
        }

        // create new data
        $data_update = [
            "nama_barang" => $req['nama_barang'],
            "kode_barang" => $req['kode_barang'],
            "nup" => $req['nup'],
            "merk" => $req['merk'],
            "tahun_perolehan" => $req['tahun_perolehan'],
            "nilai_perolehan" => $req['nilai_perolehan'],
            "b" => $b,
            "rr" => $rr,
            "rb" => $rb,
            "keterangan" => $req['keterangan']
        ];

        $res = $BangunanLainnya->update($data_update);
        // check if data is successfully updated
        if (!$res) {
            return Redirect::route('bangunan-lainnya')->with('error', 'Gagal mengubah data');
        }

        return Redirect::route('bangunan-lainnya');
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
        return Excel::download(new BangunanLainnyaExport(), 'laporan_bangunan_lainnya_' . $tanggal . '.xlsx');
    }
}
