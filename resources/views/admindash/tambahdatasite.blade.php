@extends('layouts.sidebaradmin')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Profile</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('addsiteproses') }}" method="POST">
                    @csrf
                    <!-- Form fields go here -->
                    <!-- Example: -->
                    <div class="form-group">
                        <label for="nama">Nama site :</label>
                        <input type="text" class="form-control form-control-user" name="nama" id="nama" placeholder="Nama Departemen" value="{{old('nama')}}">
                        <label for="latitude">Latitude Site:</label>
                        <input type="text" class="form-control form-control-user" name="latitude" id="latitude" placeholder="Latitude Site" min="0" value="{{old('latitude')}}">
                        <label for="longitude">longitude Site:</label>
                        <input type="text" class="form-control form-control-user" name="longitude" id="longitude" placeholder="Longitude Site" min="0" value="{{old('longitude')}}">
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
            const nama = document.querySelector('#nama').value;
            const latitude = document.querySelector('#latitude').value;
            const longitude = document.querySelector('#longitude').value;

            // Check if any of the input fields are empty
            if (
                nama === '' ||latitude === ''||longitude === ''
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
