<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik',$nik)->where('tgl_presensi', $hariini)->first();
        return view ('dashboard.presensi', compact('presensihariini'));
    }
    public function indexadmin()
    {
        $hariini = date("Y-m-d");
        $jmlkaryawan = DB::table('karyawan')->selectRaw('COUNT(nik) as jmlkaryawan')->first();
        $rekappresensi = DB::table('presensi')->selectRaw('COUNT(nik) as jmlhadir')
        ->where('tgl_presensi',$hariini)->first();
        return view ('admindash.admindashboard', compact('rekappresensi', 'jmlkaryawan'));
    }

}
