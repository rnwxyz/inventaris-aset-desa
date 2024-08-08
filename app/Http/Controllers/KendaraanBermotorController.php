<?php

namespace App\Http\Controllers;

use App\Exports\KendaraanBermotorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\KendaraanBermotorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KendaraanBermotorController extends Controller
{
    public function index()
    {
        // get all data from peralatan_mesin table
        $kendaraanBermotor = KendaraanBermotorModel::all();

        return view('kendaraan-bermotor', compact('kendaraanBermotor'));
    }

    public function store(Request $request)
    {
        // mapping request data to model
        $req = $request->all();

        // check duplicate kode_barang
        $isExist = KendaraanBermotorModel::where('kode_barang', $req['kode_barang'])->first();
        if ($isExist) {
            return Redirect::route('kendaraan-bermotor')->with('error', 'Barang dengan kode ' . $req['kode_barang'] . ' sudah ada');
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

        $res = KendaraanBermotorModel::create($data_input);
        // check if data is successfully created
        if (!$res) {
            return Redirect::route('kendaraan-bermotor')->with('error', 'Gagal menambahkan data');
        }

        return Redirect::route('kendaraan-bermotor');
    }

    public function delete($id)
    {
        KendaraanBermotorModel::destroy($id);

        return Redirect::route('kendaraan-bermotor');
    }

    public function update(Request $request, $id)
    {
        $kendaraanBermotor = KendaraanBermotorModel::find($id);
        // mapping request data to model
        $req = $request->all();

        // check duplicate kode_barang except current data
        $isExist = KendaraanBermotorModel::where('kode_barang', $req['kode_barang'])->where('id', '!=', $id)->first();
        if ($isExist) {
            return Redirect::route('kendaraan-bermotor')->with('error', 'Barang dengan kode ' . $req['kode_barang'] . ' sudah ada');
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

        $res = $kendaraanBermotor->update($data_update);
        // check if data is successfully updated
        if (!$res) {
            return Redirect::route('kendaraan-bermotor')->with('error', 'Gagal mengubah data');
        }

        return Redirect::route('kendaraan-bermotor');
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
        return Excel::download(new KendaraanBermotorExport(), 'laporan_kendaraan_bermotor_' . $tanggal . '.xlsx');
    }
}
