@extends('layouts.sidebar') <!-- Jika Anda menggunakan layout bawaan Laravel -->

@section('container')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Riwayat Absen</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Riwayat Absen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari, Tanggal</th>
                            <th>Koordinate-Site</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Foto Mulai</th>
                            <th>Foto Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presensi as $absen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($absen->tgl_presensi)->format('l, d F Y') }}</td>
                            <td>{{ $absen->lokasi_in }}</td>
                            <td>{{ $absen->jam_in }}</td>
                            <td>{{ $absen->jam_out }}</td>
                            <td>
                                <img src="{{ asset('storage/uploads/absensi/' . $absen->foto_in) }}" alt="Foto Mulai"
                                    width="100">
                            </td>
                            <td>
                                <img src="{{ asset('storage/uploads/absensi/' . $absen->foto_out) }}"
                                    alt="Foto Selesai" width="100">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
