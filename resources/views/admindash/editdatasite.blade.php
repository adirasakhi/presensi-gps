@extends('layouts.sidebaradmin')
@section('title', 'Site')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Karyawan</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('editsite') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Display the current profile photo -->

                    <div class="form-group">
                        <label for="id">id</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $departemen->id }}">
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Site :</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $departemen->nama }}">
                    </div>
                    <div class="form-group">
                        <label for="latitude">Latitude Site :</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $departemen->latitude }}">
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude Site :</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $departemen->longitude }}">
                    </div>

                    <button type="submit" class="btn btn-primary" id="savesite">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const submitButton = document.querySelector('#savesite');

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Get input values
            const nama = document.querySelector('#nama').value;
            const latitude = document.querySelector('#latitude').value;
            const longitude = document.querySelector('#longitude').value;

            form.submit();
                Swal.fire('Success', 'Data berhasil Diupdate', 'success');
        });
    })
</script>
@include('layouts.footer')
@include('layouts.script')
@endsection
