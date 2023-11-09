<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class SiteController extends Controller
{
    public function index()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $sites = Site::all();
        $presensi = DB::table('presensi')->get(); // Ganti 'presensi' dengan nama tabel yang sesuai

        // Filter data untuk hanya menampilkan koordinat yang sesuai
        $filteredSites = [];

        foreach ($sites as $site) {
            foreach ($presensi as $absen) {
                // Pastikan $absen memiliki property lokasi_in
                if (property_exists($absen, 'lokasi_in')) {
                    $distance = $this->calculateDistance($absen->lokasi_in, $site->latitude, $site->longitude);
                    if ($distance <= 50 && $absen->nik == Auth::guard('karyawan')->user()->nik) {
                        $filteredSites[] = [
                            'nama' => $site->nama,
                            'tanggal' => $absen->tgl_presensi,
                            'jam_masuk' => $absen->foto_in,
                            'jam_keluar' => $absen->foto_out,
                            'koordinat' => $site->latitude . ', ' . $site->longitude,
                            'nik' => $absen->nik,
                        ];
                    }
                }
            }
        }

        // Debug data

        return view('dashboard.site', compact('filteredSites'));
    }

    // Fungsi untuk menghitung jarak
    public function calculateDistance($lokasi_in, $lat2, $lon2)
    {
        // Mendapatkan latitude dan longitude dari lokasi_in
        $lokasiuser = explode(",", $lokasi_in);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        // Haversine formula
        $radlat1 = deg2rad($latitudeuser);
        $radlat2 = deg2rad($lat2);
        $dlat = $radlat2 - $radlat1;
        $dlon = deg2rad($lon2) - deg2rad($longitudeuser);
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($radlat1) * cos($radlat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = 6371 * $c * 1000; // Mengonversi ke meter
        return $distance;
    }
}
