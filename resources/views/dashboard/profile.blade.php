@extends('layouts.sidebar')
@section('container')
     <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"> Bioadata</h1>
                    <!-- card -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <div class="d-flex justify-content-center">
                        <div class="card d-flex justify-content-center" style="width: 500px; height: 300px;">
                            <div class="card-body">
                                <div class="Gambar d-flex justify-content-center align-items-end bg-gradient-danger" style="height: 170px;">
                                    @if(Auth::guard('karyawan')->user()->foto != null)
                                    <img class="rounded-circle shadow-4-strong" src="{{ asset('profile_images/' . Auth::guard('karyawan')->user()->nik . '.png') }}" alt="Profile Image" style="height: 120px; width: 120px;">
                                @else
                                    <img src="{{ asset('profile_images/default.svg') }}" alt="Default Profile Image" style="height: 120px; width: 120px;">
                                @endif
                            </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <div class="text-center">
                                        <h2>{{ Auth::guard('karyawan')->user()->name }}</h2>
                                        <h3>{{ Auth::guard('karyawan')->user()->jabatan }}</h3>
                                    </div>
                                </div>

                            </div>
                          </div>
                    </div>
                    <!-- end card -->
                    <!-- card -->
                    <div class="d-flex justify-content-center mt-3">
                        <div class="card d-flex justify-content-center border border-dark" style="width: 560px; height: 350px;">
                            <div class="card-body">
                                <div class="form-group d-flex">
                                    <label for="name" style="margin-right: 120px">Nama </label>
                                    <label type="name" id="name">: {{ Auth::guard('karyawan')->user()->name }}</label>
                                  </div>
                                <div class="form-group d-flex">
                                    <label for="nik" style="margin-right: 135px">NIK </label>
                                    <label type="nik" id="nik">: {{ Auth::guard('karyawan')->user()->nik }}</label>
                                  </div>

                                <div class="form-group d-flex">
                                    <label for="gender" style="margin-right: 65px">Jenis Kelamin </label>
                                    <label type="gender" id="gender">: {{ Auth::guard('karyawan')->user()->jenis_kelamin }}</label>
                                  </div>
                                <div class="form-group d-flex">
                                    <label for="date" style="margin-right: 5px">Tempat,Tanggal Lahir </label>
                                    <label type="date" id="date">: {{ Auth::guard('karyawan')->user()->tempat_tanggal_lahir }}</label>
                                  </div>
                                <div class="form-group d-flex">
                                    <label for="notelp" style="margin-right: 80px">No telepon </label>
                                    <label type="notelp" id="notelp">: {{ Auth::guard('karyawan')->user()->phone }}</label>
                                  </div>
                                <div class="form-group d-flex">
                                    <label for="jabatan" style="margin-right: 105px">Jabatan </label>
                                    <label type="jabatan" id="jabatan">: {{ Auth::guard('karyawan')->user()->jabatan }}</label>
                                  </div>
                                <div class="d-flex justify-content-center"><a href="{{ route('edit-profile') }}">
                                    <button class="btn btn-danger">Edit</button>

                                  </a>
                                  </div>
                            </div>

                          </div>
                    </div>
                    <!-- end card -->
                    </div>

                </div>
                @include('layouts.footer')
                @include('layouts.script')
@endsection
