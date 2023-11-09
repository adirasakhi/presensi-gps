<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Site;
use Illuminate\Support\Facades\DB;


class HistoryController extends Controller
{
    //
    public function index(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensi = DB::table('presensi')->where('nik', $nik)->get();
        return view ('dashboard.riwayat', compact('presensi'));
    }

}
