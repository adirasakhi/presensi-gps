<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;



class PresensiController extends Controller
{
    public function create()
    {
        date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu ke WIB

        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $sites = Site::all();
        return view('presensi.create', compact('cek','sites'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        // Menghitung jarak
        $sites = Site::all(); // Pindahkan ini ke sini untuk mendapatkan data lokasi kantor
        $radius = PHP_INT_MAX; // Inisialisasi radius dengan nilai maksimum
        foreach ($sites as $site) {
            $latitudekantor = $site->latitude;
            $longitudekantor = $site->longitude;

            $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
            $jarakMeters = $jarak["meters"];
            if ($jarakMeters < $radius) {
                $radius = $jarakMeters; // Update radius jika ditemukan jarak yang lebih kecil
            }
        }

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if ($radius > 50) {
            echo "error|Maaf Anda Berada Diluar Radius.|radius";
        } else {
            $image = $request->image;

            if (strpos($image, ';base64') !== false) {
                $image_parts = explode(";base64", $image);
                $image_base64 = base64_decode($image_parts[1]);

                $folderPath = "public/uploads/absensi/";
                $ket = ($cek > 0) ? 'out' : 'in'; // Ubah ket menjadi 'out' jika sudah ada data presensi

                // Buat nama file yang berbeda untuk 'in' dan 'out'
                $formatName = $nik . "-" . $tgl_presensi . "-" . $jam . "-" . $ket . ".png";
                $fileName = $formatName;

                if ($ket === 'out') {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_in' => $lokasi,
                    ];

                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);

                    if ($update) {
                        echo "success|Terima Kasih, Hati-Hati di Jalan|out";
                        Storage::put($folderPath . $fileName, $image_base64);
                    } else {
                        echo "error|Maaf Gagal Absen. Silakan Hubungi Tim IT|out";
                    }
                } else {
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                    ];

                    $simpan = DB::table('presensi')->insert($data);

                    Storage::put($folderPath . $fileName, $image_base64);

                    if ($simpan) {
                        echo "success|Terima Kasih, Selamat Bekerja|in";
                    } else {
                        echo "error|Maaf Gagal Absen. Silakan Hubungi Tim IT|out";
                    }
                }
            }
        }
    }
  //Menghitung Jarak
  function distance($lat1, $lon1, $lat2, $lon2)
  {
      $theta = $lon1 - $lon2;
      $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
      $miles = acos($miles);
      $miles = rad2deg($miles);
      $miles = $miles * 60 * 1.1515;
      $feet = $miles * 5280;
      $yards = $feet / 3;
      $kilometers = $miles * 1.609344;
      $meters = $kilometers * 1000;
      return compact('meters');
  }
  public function edit()
  {
      $nik = Auth::guard('karyawan')->user()->nik;
      $karyawan = DB::table('karyawan')->where('nik',$nik)->first();
      return view('dashboard.edit-profile', compact('karyawan'));
  }

  public function update(Request $request)
{
    $nik = Auth::guard('karyawan')->user()->nik;
    $name = $request->name;
    $phone = $request->phone;
    $tempat_tanggal_lahir = $request->tempat_tanggal_lahir;
    $password = Hash::make($request->password);
    $karyawan = DB::table('karyawan')->where('nik', $nik)->first();

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
            'foto' => $foto
        ];
    } else {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'tempat_tanggal_lahir' => $tempat_tanggal_lahir,
            'foto' => $foto,
            'password' => $password
        ];
    }

    $update = DB::table('karyawan')->where('nik', $nik)->update($data);

    if ($update) {
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    } else {
        return redirect()->back()->with('error', 'Failed to update profile');
    }
}
public function monitoring()
{
    return view('admindash.monitoring');
}
public function getpresensi(Request $request){
    $tanggal = $request->tanggal;

    $presensi = DB::table('presensi')
        ->select('presensi.*', 'name', 'nama_dept')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
        ->where('tgl_presensi', $tanggal)
        ->get();

    return view('admindash.getpresensi', compact('presensi'));
}


}
