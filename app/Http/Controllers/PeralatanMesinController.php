<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeralatanMesinRequest;
use App\Models\PeralatanMesinModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PeralatanMesinController extends Controller
{
    public function index()
    {
        // get all data from peralatan_mesin table
        $peralatanMesin = PeralatanMesinModel::all();

        return view('peralatan-mesin', compact('peralatanMesin'));
    }

    public function store(Request $request)
    {
        // mapping request data to model
        $req = $request->all();

        // check duplicate kode_barang
        $isExist = PeralatanMesinModel::where('kode_barang', $req['kode_barang'])->first();
        if ($isExist) {
            return Redirect::route('peralatan-mesin')->with('error', 'Barang dengan kode ' . $req['kode_barang'] . ' sudah ada');
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

        $res = PeralatanMesinModel::create($data_input);
        // check if data is successfully created
        if (!$res) {
            return Redirect::route('peralatan-mesin')->with('error', 'Gagal menambahkan data');
        }

        return Redirect::route('peralatan-mesin');
    }

    public function delete($id)
    {
        PeralatanMesinModel::destroy($id);

        return Redirect::route('peralatan-mesin');
    }

    public function update(Request $request, $id)
    {
        $peralatanMesin = PeralatanMesinModel::find($id);
        // mapping request data to model
        $req = $request->all();

        // check duplicate kode_barang except current data
        $isExist = PeralatanMesinModel::where('kode_barang', $req['kode_barang'])->where('id', '!=', $id)->first();
        if ($isExist) {
            return Redirect::route('peralatan-mesin')->with('error', 'Barang dengan kode ' . $req['kode_barang'] . ' sudah ada');
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

        $res = $peralatanMesin->update($data_update);
        // check if data is successfully updated
        if (!$res) {
            return Redirect::route('peralatan-mesin')->with('error', 'Gagal mengubah data');
        }

        return Redirect::route('peralatan-mesin');
    }
}
