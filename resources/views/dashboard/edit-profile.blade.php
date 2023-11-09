@extends('layouts.sidebar')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Profile</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Display the current profile photo -->
                    <input type="file" name="foto">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $karyawan->name }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $karyawan->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="tempat_tanggal_lahir">Date of Birth</label>
                        <input type="text" class="form-control" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" value="{{ $karyawan->tempat_tanggal_lahir }}">
                    </div>

                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ $karyawan->nik }}">
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@include('layouts.script')
@endsection
