<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Mail\CheckInNotification;
use App\Models\Presensi;
use Illuminate\Support\Facades\Mail;



class PresensiController extends Controller
{
    public function create()
    {
        date_default_timezone_set('Asia/Jakarta'); // Atur zona waktu ke WIB

        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $presensi = DB::table(('presensi'))->get();
        $sites = Site::all();
        return view('presensi.create', compact('cek','presensi','sites'));
    }
    public function storeizin()
    {

        return view('presensi.izin');
    }
    public function dataizin(Request $request)
    {

        return view('presensi.izin');
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasi = $request->lokasi;
        $detail = $request->detail;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        // Menghitung jarak
        $sites = Site::all();
        $radius = PHP_INT_MAX;

        foreach ($sites as $site) {
            $latitudekantor = $site->latitude;
            $longitudekantor = $site->longitude;

            $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
            $jarakMeters = $jarak["meters"];
            if ($jarakMeters < $radius) {
                $radius = $jarakMeters;
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
                $ket = ($cek > 0) ? 'out' : 'in';

                $formatName = $nik . "-" . $tgl_presensi . "-" . $jam . "-" . $ket . ".png";
                $fileName = $formatName;

                if ($ket === 'out') {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'detail' => $detail,
                        'lokasi_in' => $lokasi,
                    ];

                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);

                    if ($update) {
                        echo "success|Terima Kasih, Hati-Hati di Jalan|out";

                        // Kirim email disini
                        $presensiData = Presensi::whereDate('tgl_presensi', now()->toDateString())->get();
                        try {
                            Mail::to('loloxthree@gmail.com')->send(new CheckInNotification($presensiData));
                            return "Email presensi berhasil dikirim.";
                        } catch (\Exception $e) {
                            return "Error: Gagal mengirim email. " . $e->getMessage();
                        }

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
                        'detail' => $detail,
                        'lokasi_in' => $lokasi,
                    ];

                    $simpan = DB::table('presensi')->insert($data);

                    Storage::put($folderPath . $fileName, $image_base64);

                    if ($simpan) {
                        echo "success|Terima Kasih, Selamat Bekerja|in";

                        // Kirim email disini
                        $presensiData = Presensi::whereDate('tgl_presensi', now()->toDateString())->get();
                        try {
                            Mail::to('loloxthree@gmail.com')->send(new CheckInNotification($presensiData));
                            return "Email presensi berhasil dikirim.";
                        } catch (\Exception $e) {
                            return "Error: Gagal mengirim email. " . $e->getMessage();
                        }
                    } else {
                        echo "error|Maaf Gagal Absen. Silakan Hubungi Tim IT|out";
                    }
                }
            }
        }
    }

    // public function sendPresensiEmail()
    // {
    //     // Ambil data presensi hari ini
    //     $presensiData = Presensi::whereDate('tgl_presensi', now()->toDateString())->get();

    //     // Kirim email
    //     try {
    //         Mail::to('loloxthree@gmail.com')->send(new CheckInNotification($presensiData));

    //         // Tambahkan pesan sukses jika email berhasil dikirim
    //         return "Email presensi berhasil dikirim.";
    //     } catch (\Exception $e) {
    //         // Tambahkan pesan error jika terjadi kesalahan
    //         return "Error: Gagal mengirim email. " . $e->getMessage();
    //     }
    // }
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
    $plat_no = $request->plat_no;
    $perusahaan = $request->perusahaan;
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
            'plat_no' => $plat_no,
            'perusahaan' => $perusahaan,
            'foto' => $foto
        ];
    } else {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'plat_no' => $plat_no,
            'perusahaan' => $perusahaan,
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
        ->select('presensi.*', 'name', 'perusahaan')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->where('tgl_presensi', $tanggal)
        ->get();

    return view('admindash.getpresensi', compact('presensi'));
}


}
