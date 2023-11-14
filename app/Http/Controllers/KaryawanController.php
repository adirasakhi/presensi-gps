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
        $departemen =DB::table('departemen')->get();
        $query = Karyawan::query();
        $query->select('karyawan.*','nama_dept');
        $query->join('departemen','karyawan.kode_dept','=','departemen.kode_dept');
        $query->orderBy('name');
        if(!empty($request->name)){
            $query->where('name','like','%'.$request->name.'%');
        }
        if(!empty($request->kode_dept)){
            $query->where('karyawan.kode_dept','like',$request->kode_dept);
        }
        $karyawan = $query->paginate(20);

        return view ('admindash.datakaryawan',compact('karyawan','departemen'));
    }
    public function tambahkaryawan(Request $request){
        $departemen =DB::table('departemen')->get();
        $karyawan = DB::table('karyawan')->get();
        return view ('admindash.tambahkaryawan',compact('karyawan','departemen'));

    }
    public function store(Request $request){
        $nik = $request->nik;
        $jabatan = $request->jabatan;
        $email = $request->email;
        $tempat_tanggal_lahir = $request->tempat_tanggal_lahir;
        $jenis_kelamin = $request->jenis_kelamin;
        $phone = $request->phone;
        $name = $request->name;
        $kode_dept = $request->kode_dept;

        $data = [
            'nik'=>$nik,
            'name'=>$name,
            'email'=>$email,
            'jabatan'=>$jabatan,
            'tempat_tanggal_lahir'=>$tempat_tanggal_lahir,
            'jenis_kelamin'=>$jenis_kelamin,
            'phone'=>$phone,
            'kode_dept'=>$kode_dept,
            'password' => Hash::make($request->password),
        ];
        $simpan = DB::table('karyawan')->insert($data);
        if($simpan){
            return redirect()->route('datakaryawan')->with('success', 'Data berhasil ditambahkan');
        }else{
            return redirect()->back()->with('failed', 'data tidak berhasil ditambahkan');
        }
    }
    public function editdatakaryawan($nik){
        $karyawan = Karyawan::find($nik);
        $departemen =DB::table('departemen')->get();


        if (!$karyawan) {
            return abort(404); // Or you can handle the case when the employee is not found.
        }

        return view('admindash.editdatakaryawan', compact('karyawan','departemen'));
    }
    public function editkaryawan(Request $request){
    $nik = $request->nik;
    $name = $request->name;
    $phone = $request->phone;
    $tempat_tanggal_lahir = $request->tempat_tanggal_lahir;
    $password = Hash::make($request->password);
    $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
    $kode_dept = $request->kode_dept;

    // Check if a file was uploaded
    if ($request->hasFile('foto')) {
        $uploadedFile = $request->file('foto');

        // Modify the extension to .png
        $foto = $nik . ".png";

        // Move the uploaded file to the destination with the modified extension
        $uploadedFile->move(public_path('profile_images'), $foto);
    } else {
        $foto = $karyawan->foto;
    }

    if (empty($request->password)) {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'tempat_tanggal_lahir' => $tempat_tanggal_lahir,
            'foto' => $foto,
            'kode_dept' => $kode_dept

        ];
    } else {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'tempat_tanggal_lahir' => $tempat_tanggal_lahir,
            'foto' => $foto,
            'kode_dept' => $kode_dept,
            'password' => $password
        ];
    }

    $update = DB::table('karyawan')->where('nik', $nik)->update($data);

    if ($update) {
        return redirect()->route('datakaryawan')->with('success', 'Data Karyawan berhasil diupdate ');
    } else {
        return redirect()->back()->with('error', 'Data gagal di update');
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
