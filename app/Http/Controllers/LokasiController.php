<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $nama = $request->nama;
        $query = Site::query();
        $query->select('*');
        if (!empty($nama)) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }
        $lokasi = $query->get();
        return view('admindash.datalokasiSite', compact('lokasi'));
    }

    public function tambahsite()
    {
        $departemen = DB::table('sites')->get();
        $karyawan = DB::table('karyawan')->get();
        return view('admindash.tambahdatasite', compact('karyawan', 'departemen'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama;
        $lokasi = $request->lokasi;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $data = [
            'nama' => $nama,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
        $simpan = DB::table('sites')->insert($data);
        if ($simpan) {
            return redirect()->route('lokasisite')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()->with('failed', 'data tidak berhasil ditambahkan');
        }
    }

    public function editdata($id)
    {
        $departemen = Site::find($id);

        if (!$departemen) {
            return abort(404); // Or you can handle the case when the departemen is not found.
        }

        return view('admindash.editdatasite', compact('departemen'));
    }

    public function editsite(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;

        $data = [
            'nama' => $nama,
        ];

        $updateCount = DB::table('sites')->where('id', $id)->update($data);
        if ($updateCount > 0) {
            return redirect()->route('lokasisite')->with('success', 'Data departemen berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Data gagal diupdate atau data tidak ditemukan');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        try {
            $departemen = Site::findOrFail($id);
            $departemen->delete();

            return redirect()->back()->with('success', 'Data Site berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data gagal dihapus atau data tidak ditemukan');
        }}

}
