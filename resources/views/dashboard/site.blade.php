@extends('layouts.sidebar')
@section('title', 'Site')
@section('container')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Site Yang Dikunjungi</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kegiatan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Site</th>
                            <th>Tanggal</th>
                            <th>jam masuk</th>
                            <th>jam keluar</th>
                            <th>Koordinat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filteredSites as $item)
    @php
        list($latitude, $longitude) = explode(',', $item['koordinat']);
    @endphp
    @if ($item['nik'] == Auth::guard('karyawan')->user()->nik)
        <tr>
            <td>{{ $item['nama'] }}</td>
            <td>{{ $item['tanggal'] }}</td>
            <td>{{ $item['jam_masuk'] }}</td>
            <td>{{ $item['jam_keluar'] }}</td>
            <td>{{ $latitude }}, {{ $longitude }}</td>
        </tr>
    @endif
@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
