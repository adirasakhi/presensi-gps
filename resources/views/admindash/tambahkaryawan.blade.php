@extends('layouts.sidebaradmin')
@section('title', 'Karyawan')
@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Tambah Karyawan</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('addkaryawanproses') }}" method="POST">
                    @csrf
                    <!-- Form fields go here -->
                    <!-- Example: -->
                    <div class="form-group">
                        <label for="nik">Nik Karyawan :</label>
                        <input type="number" class="form-control form-control-user" name="nik" id="nik" placeholder="Id Card/ KTP" min="0" value="{{old('nik')}}">
                        <label for="name">Nama Karyawan :</label>
                        <input type="text" name="name" id="name" class="form-control" {{old('name')}}>
                        <label for="email">Email Karyawan :</label>
                        <input type="text" name="email" id="email" class="form-control" {{old('email')}}>
                        <label for="jabatan">Jabatan :</label>
                        <input type="text" class="form-control form-control-user" name="jabatan" id="jabatan" placeholder="Jabatan" min="0" value="{{old('jabatan')}}">
                        <label for="phone">No Telpon :</label>
                        <input type="text" name="phone" id="phone" class="form-control" {{old('phone')}}>
                        <label for="tempat_tanggal_lahir">Tempat Tanggal Lahir :</label>
                        <input type="text" name="tempat_tanggal_lahir" id="tempat_tanggal_lahir" class="form-control" {{old('tempat_tanggal_lahir')}}>
                        <label for="jenis_kelamin">jenis kelamin :</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" {{old('jenis_kelamin')}}>
                            <option value="">jenis kelamin</option>
                            <option value="laki-laki">laki-laki</option>
                            <option value="perempuan">perempuan</option>
                        </select>
                        <label for="kode_dept">Departemen :</label>
                        <select name="kode_dept" id="kode_dept" class="form-control" {{old('kode_dept')}}>
                            <option value="">Departemen</option>
                            @foreach ($departemen as $item)
                                <option {{ Request('kode_dept')==$item->kode_dept ? 'selected':'' }} value="{{ $item->kode_dept }}">{{ $item->nama_dept }}</option>
                            @endforeach
                        </select>
                        <label for="password">password :</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary" id="savekaryawan">tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            // Check if any of the input fields are empty
            if (
                nik === '' ||
                name === '' ||
                email === '' ||
                jabatan === '' ||
                phone === '' ||
                tempat_tanggal_lahir === '' ||
                jenis_kelamin === '' ||
                kode_dept === '' ||
                password === ''
            ) {
                Swal.fire('Data harus diisi', 'Semua field harus diisi.', 'error');
            } else {
                // If all fields are filled, submit the form
                form.submit();
                Swal.fire('Success', 'Data berhasil ditambahkan', 'success');
            }
        });
    });
</script>



@include('layouts.scriptadmin')
@endsection
