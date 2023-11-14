<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;




class AuthController extends Controller
{
    //
    public function prosesLogin(Request $request){
        if(Auth::guard('karyawan')->attempt(['email' => $request -> email, 'password' => $request -> password])){
            return redirect('/home');
        }else{
            return redirect('/')->with('failed','Email Atau Password Salah');
        }
    }
    public function prosesLoginadmin(Request $request){
        if(Auth::guard('user')->attempt(['email' => $request -> email, 'password' => $request -> password])){
            return redirect('/panel/adminpanel');
        }else{
            return redirect('/panel')->with('failed','Email Atau Password Salah');
        }
    }

    public function prosesLogout(){
        if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
        }
        return redirect('/');

    }
    public function prosesLogoutadmin(){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
        }
        return redirect('/panel');
    }
    public function register(){
        $departemen =DB::table('departemen')->get();

        return view('auth.register',compact('departemen'));
    }

    public function register_proses(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:karyawan,email',
            'password' => 'required|min:6',
            'nik' => 'required|unique:karyawan,nik',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_tanggal_lahir' => 'required',
            'phone' => 'required',
            'kode_dept' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
            'phone' => $request->phone,
            'kode_dept' => $request->kode_dept,

        ];

        Karyawan::create($data);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('karyawan')->attempt($login)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with('failed', 'Email Atau Password Salah');
        }
    }


}
