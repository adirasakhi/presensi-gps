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
            return redirect('/verfication');
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

        return view('auth.register');
    }

    public function register_proses(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:karyawan,email',
            'password' => 'required|min:6',
            'nik' => 'required|unique:karyawan,nik',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'plat_no' => 'required',
            'perusahaan' => 'required',
            'phone' => 'required',
            'face' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'plat_no' => $request->plat_no,
            'perusahaan' => $request->perusahaan,
            'phone' => $request->phone,

        ];

        if ($request->hasFile('face')) {
            $file = $request->file('face');
            $fileName = $request->input('email') . '_face.jpg';
            $file->move(public_path('uploads'), $fileName);

            // Save the file name to the database
            $data['face'] = $fileName;
        }
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
