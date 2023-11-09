@extends('layouts.sidebar')
@section('container')
    <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="container-fluid">
                        <div class="row page-titles mx-0">
                            <div class="col-sm-6 p-md-0">
                                <div class="welcome-text">
                                    <h4>Hi, Selamat datang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xxl-12 col-md-12">
                                        <div class="card">
                                            <div class="btn btn-danger text-center">
                    <div style="font-size: 48px;" id="jam"></div>
                    <div id="tampil_tanggal"></div>
                        {{-- script untuk tanggal --}}
                            <script>
                window.onload = function() {
                                jam();
                            }

                            function jam() {
                                var e = document.getElementById('jam'),
                                    d = new Date(),
                                    h, m, s;
                                    h = d.getHours();
                                    m = set(d.getMinutes());
                                    s = set(d.getSeconds());
                                    e.innerHTML = h + ':' + m + ':' + s;
                                    setTimeout('jam()', 1000);
                                }

                            function set(e) {
                                e = e < 10 ? '0' + e : e;
                                    return e;
                                }
                var date = new Date();
                var tahun = date.getFullYear();
                var bulan = date.getMonth();
                var tanggal = date.getDate();
                var hari = date.getDay();
                var jam_tanggal = date.getHours();
                var menit_tanggal = date.getMinutes();
                var detik_tanggal = date.getSeconds();
                switch(hari) {
                case 0: hari = "Minggu"; break;
                case 1: hari = "Senin"; break;
                case 2: hari = "Selasa"; break;
                case 3: hari = "Rabu"; break;
                case 4: hari = "Kamis"; break;
                case 5: hari = "Jum'at"; break;
                case 6: hari = "Sabtu"; break;
                }
                switch(bulan) {
                case 0: bulan = "Januari"; break;
                case 1: bulan = "Februari"; break;
                case 2: bulan = "Maret"; break;
                case 3: bulan = "April"; break;
                case 4: bulan = "Mei"; break;
                case 5: bulan = "Juni"; break;
                case 6: bulan = "Juli"; break;
                case 7: bulan = "Agustus"; break;
                case 8: bulan = "September"; break;
                case 9: bulan = "Oktober"; break;
                case 10: bulan = "November"; break;
                case 11: bulan = "Desember"; break;
                }
                var tampilTanggal = hari + ", " + tanggal + " " + bulan + " " + tahun;

                    document.getElementById("tampil_tanggal").innerHTML = tampilTanggal;
    </script>
                        {{-- akhir script tanggal --}}
                    </div>
                        <div class="row">
                        <div class="col-6 border-right">
                        <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                            @if ($presensihariini != null && $presensihariini->foto_in != null)
                            <button class="btn btn-danger" disabled id="btn-absen-masuk">Masuk</button>
                        @else
                            <a href="{{ route('presensi.create') }}"><button class="btn btn-danger" id="btn-absen-masuk">Masuk</button></a>
                        @endif
                        <p id="absen-masuk" class="m-0">Masuk</p>
                    </div>
                    <div class="bootstrap-modal">
                        <!-- Modal -->
                        <div class="modal fade" id="masukModal">
                            <div class="modal-dialog" role="document">
                                <form action="partisipant/mulai" method="post" enctype="multipart/form-data">
                                <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Masuk</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>×</span>
                                </button>
                                </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text">Akses Kamera</span>
                            </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label">Pilih Foto</label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text">Keterangan</span>
                            </div>
                        <div class="custom-file">
                            <!-- jenis absen -->
                            <select name="presence_type" id="inputState" class="form-control">
                                <option name="presence_type" selected="">Pilih Keadaan Site</option>
                                <option value="1">Akses Lancar</option>
                                <option value="2">Block Akses</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                        </div>
                        </form>
                        <!-- akhir form -->
                        </div>
                        </div>
                        <div class="modal fade" id="selesaiModal">
                        <div class="modal-dialog" role="document">
                            <form action="partisipant/selesai" method="post" enctype="multipart/form-data">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Absen Pulang</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Unggah</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image">
                            <label class="custom-file-label">Pilih Foto</label>
                        </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                        </div>
                            </form>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="col-6">
                        <div class="pt-3 pb-3 pl-0 pr-0 text-center">
                            @if ($presensihariini != null && $presensihariini->foto_in != null)
                            @if ($presensihariini->foto_out != null)
                                <button class="btn btn-danger" disabled>Selesai</button>
                            @else
                                <a href="{{ route('presensi.create') }}" class="btn btn-danger" id="absen-selesai">Selesai</a>
                            @endif
                        @else
                            <button class="btn btn-danger" onclick="showAbsenAlert()" id="btn-absen-selesai">Selesai</button>
                        @endif
                        <p class="m-0">Pulang</p>

                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Riwayat Absen</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div id="example_wrapper" class="dataTables_wrapper no-footer">

                                            <table id="example" class="table table-bordered" style="min-width: 845px" role="grid" aria-describedby="example_info">
                                                <thead>
                                                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="No: activate to sort column descending" style="width: 27.7344px;">No</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Hari, Tanggal: activate to sort column ascending" style="width: 204.812px;">Hari, Tanggal</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Foto Mulai: activate to sort column ascending" style="width: 86.7656px;">Foto Mulai</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Foto Selesai: activate to sort column ascending" style="width: 100.984px;">Foto Selesai</th>
                                                    </tr>
                                                    <td>
                                                        @php
                                                                $no = 1;
                                                        @endphp
                                                        {{ $no++ }}
                                                    </td>
                                                    <td> @if (isset($presensihariini) && $presensihariini->tgl_presensi != null)
                                                        {{ \Carbon\Carbon::parse($presensihariini->tgl_presensi)->format('l, d F Y') }}
                                                    @else
                                                        Belum Absen
                                                    @endif</td>
                                                    <td>
                                                        @if ($presensihariini != null)
                                                        @php
                                                        $path = Storage::url('uploads/absensi/'.$presensihariini->foto_in)
                                                    @endphp
                                                        <img src="{{ url($path) }}" alt="" height="150px" width="150px">
                                                        @endif
                                                        <br>
                                                        {{ $presensihariini != null ? $presensihariini->foto_in : 'Belum Absen'}}</td>
                                                    <td>
                                                    @if ($presensihariini != null)
                                                        @php
                                                        $path = Storage::url('uploads/absensi/'.$presensihariini->foto_out)
                                                    @endphp
                                                        <img src="{{ url($path) }}" alt="" height="150px" width="150px">
                                                        @endif
                                                        <br>
                                                        {{ $presensihariini != null && $presensihariini->foto_out != null ? $presensihariini->foto_out : 'Belum Absen'}}</td>

                                                </thead>

                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('layouts.footer')
                        @include('layouts.script')

@endsection
