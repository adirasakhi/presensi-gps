@extends('layouts.sidebaradmin')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Karyawan</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('editkaryawan') }}" method="POST" enctype="multipart/form-data">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const submitButton = document.querySelector('#savekaryawan');

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Get input values
            const nik = document.querySelector('#nik').value;
            const name = document.querySelector('#name').value;
            const email = document.querySelector('#email').value;
            const jabatan = document.querySelector('#jabatan').value;
            const phone = document.querySelector('#phone').value;
            const tempat_tanggal_lahir = document.querySelector('#tempat_tanggal_lahir').value;
            const jenis_kelamin = document.querySelector('#jenis_kelamin').value;
            const kode_dept = document.querySelector('#kode_dept').value;
            const password = document.querySelector('#password').value;

            form.submit();
                Swal.fire('Success', 'Data berhasil Diupdate', 'success');
</script>
@include('layouts.footer')
@include('layouts.script')
@endsection
