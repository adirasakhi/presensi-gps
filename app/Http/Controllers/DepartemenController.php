<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = Departemen::query();
        $query->select('*');
        if (!empty($nama_dept)) {
            $query->where('nama_dept', 'like', '%' . $nama_dept . '%');
        }
        $departemen = $query->get();
        return view('admindash.departemen', compact('departemen'));
    }

    public function tambahdepartemen()
    {
        $departemen = DB::table('departemen')->get();
        $karyawan = DB::table('karyawan')->get();
        return view('admindash.tambahdepartemen', compact('karyawan', 'departemen'));
    }

    public function store(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $kode_dept = $request->kode_dept;

        $data = [
            'nama_dept' => $nama_dept,
            'kode_dept' => $kode_dept,
        ];
        $simpan = DB::table('departemen')->insert($data);
        if ($simpan) {
            return redirect()->route('departemen')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()->with('failed', 'data tidak berhasil ditambahkan');
        }
    }

    public function editdata($id)
    {
        $departemen = Departemen::find($id);

        if (!$departemen) {
            return abort(404); // Or you can handle the case when the departemen is not found.
        }

        return view('admindash.editdatadepartemen', compact('departemen'));
    }

    public function editdepartemen(Request $request)
    {
        $id = $request->id;
        $nama_dept = $request->nama_dept;

        $data = [
            'nama_dept' => $nama_dept,
        ];

        $updateCount = DB::table('departemen')->where('id', $id)->update($data);
        if ($updateCount > 0) {
            return redirect()->route('departemen')->with('success', 'Data departemen berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Data gagal diupdate atau data tidak ditemukan');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        try {
            $departemen = Departemen::findOrFail($id);
            $departemen->delete();

            return redirect()->back()->with('success', 'Data Departemen berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data gagal dihapus atau data tidak ditemukan');
        }}

}
