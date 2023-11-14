@extends('layouts.sidebaradmin')
@section('title', 'Departemen')
@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Tambah Departemen</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('adddepartemenproses') }}" method="POST">
                    @csrf
                    <!-- Form fields go here -->
                    <!-- Example: -->
                    <div class="form-group">
                        <label for="nama_dept">Nama Departemen :</label>
                        <input type="text" class="form-control form-control-user" name="nama_dept" id="nama_dept" placeholder="Nama Departemen" value="{{old('nama_dept')}}">
                        <label for="kode_dept">Kode Departemen :</label>
                        <input type="text" class="form-control form-control-user" name="kode_dept" id="kode_dept" placeholder="Nama Departemen" min="0" value="{{old('kode_dept')}}">
                    <button type="submit" class="btn btn-primary" id="savedept">tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const submitButton = document.querySelector('#savedept');

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Get input values
            const nama_dept = document.querySelector('#nama_dept').value;
            const kode_dept = document.querySelector('#kode_dept').value;

            // Check if any of the input fields are empty
            if (
                nama_dept === '' ||
                kode_dept === ''
            ) {
                // Corrected the Swal.fire
                Swal.fire('Data harus diisi', 'Semua field harus diisi.', 'error');
            } else {
                // If all fields are filled, submit the form
                form.submit();
                Swal.fire('Success', 'Data berhasil ditambahkan', 'success');
            }
        });
    })
</script>


@include('layouts.scriptadmin')
@endsection
