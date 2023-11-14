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
        $karyawan = DB::table('karyawan')->get();
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik',$nik)->where('tgl_presensi', $hariini)->first();
        return view ('dashboard.presensi', compact('presensihariini', 'karyawan'));
    }
    public function indexadmin()
    {
        $hariini = date("Y-m-d");
        $jmlkaryawan = DB::table('karyawan')->selectRaw('COUNT(nik) as jmlkaryawan')->first();

        // Get daily attendance
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir')
            ->where('tgl_presensi', $hariini)
            ->first();

        // Get monthly attendance
        $bulanini = date("Y-m");
        $monthlyAttendance = DB::table('presensi')
            ->selectRaw('DATE(tgl_presensi) as tanggal, COUNT(nik) as jmlhadir')
            ->whereRaw('DATE_FORMAT(tgl_presensi, "%Y-%m") = ?', [$bulanini])
            ->groupBy('tanggal')
            ->get();

        // Round up the values to the nearest whole number
        $rekappresensi->jmlhadir = ceil($rekappresensi->jmlhadir);

        // Round up the values in the monthly attendance data
        foreach ($monthlyAttendance as $data) {
            $data->jmlhadir = ceil($data->jmlhadir);
        }

        // Pass the data to the view
        return view('admindash.admindashboard', compact('rekappresensi', 'monthlyAttendance','jmlkaryawan'));
    }


}
