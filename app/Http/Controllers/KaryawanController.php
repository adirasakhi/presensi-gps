<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class KaryawanController extends Controller
{
    //
    public function index(Request $request){
        $tambahan =DB::table('karyawan')->get();
        $query = Karyawan::query();
        $query->orderBy('name');
        if(!empty($request->name)){
            $query->where('name','like','%'.$request->name.'%');
        }
        if(!empty($request->kode_dept)){
            $query->where('karyawan.kode_dept','like',$request->kode_dept);
        }
        $karyawan = $query->paginate(20);

        return view ('admindash.datakaryawan',compact('karyawan','tambahan'));
    }
    public function tambahkaryawan(Request $request){
        $karyawan = DB::table('karyawan')->get();
        return view ('admindash.tambahkaryawan',compact('karyawan',));

    }
    public function store(Request $request){
        $nik = $request->nik;
        $jabatan = $request->jabatan;
        $email = $request->email;
        $jenis_kelamin = $request->jenis_kelamin;
        $phone = $request->phone;
        $name = $request->name;
        $plat_no = $request->plat_no;
        $perusahaan = $request->perusahaan;

        $data = [
            'nik'=>$nik,
            'name'=>$name,
            'email'=>$email,
            'jabatan'=>$jabatan,
            'jenis_kelamin'=>$jenis_kelamin,
            'phone'=>$phone,
            'plat_no' => $plat_no,
            'perusahaan' => $perusahaan,
            'password' => Hash::make($request->password),
        ];
        $simpan = DB::table('karyawan')->insert($data);
        if($simpan){
            return redirect()->route('datakaryawan')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->back()->with('failed', 'data tidak berhasil ditambahkan');
        }
    }

    public function delete($nik){
        $delete = DB::table('karyawan')->where('nik',$nik)->delete();
        if($delete){
            return redirect()->back()->with('success', 'Data Karyawan berhasil dihapus');
        }else{
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}
