@extends('layouts.sidebaradmin')
@section('title', 'Departemen')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Karyawan</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('editdepartemen') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Display the current profile photo -->

                    <div class="form-group">
                        <label for="id">id</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $departemen->id }}">
                    </div>

                    <div class="form-group">
                        <label for="kode_dept">Kode Departemen</label>
                        <input type="text" class="form-control" id="kode_dept" name="kode_dept" value="{{ $departemen->kode_dept }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_dept">Nama Departemen</label>
                        <input type="text" class="form-control" id="nama_dept" name="nama_dept" value="{{ $departemen->nama_dept }}">
                    </div>

                    <button type="submit" class="btn btn-primary" id="savedept">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const submitButton = document.querySelector('#savedept');

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Get input values
            const nama_dept = document.querySelector('#nama_dept').value;
            const kode_dept = document.querySelector('#kode_dept').value;

            form.submit();
                Swal.fire('Success', 'Data berhasil Diupdate', 'success');
        });
    })
</script>
@include('layouts.footer')
@include('layouts.script')
@endsection
