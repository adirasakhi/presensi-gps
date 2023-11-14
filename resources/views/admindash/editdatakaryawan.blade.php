@extends('layouts.sidebaradmin')

@section('container')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Karyawan</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="{{ route('editkaryawan') }}" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                    <!-- Display the current profile photo -->
                    <label for="foto">Foto Profile</label>
                    <br>
                    <input type="file" name="foto">
                </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $karyawan->name }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Handphone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $karyawan->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="tempat_tanggal_lahir">Tanggal Lahir</label>
                        <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                            <input class="form-control" type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" value="{{ $karyawan->tempat_tanggal_lahir }}">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ $karyawan->nik }}">
                    </div>
                    <div class="form-group">
                        <select name="kode_dept" id="kode_dept" class="form-control" {{old('kode_dept')}}>
                            <option value="">Departemen</option>
                            @foreach ($departemen as $item)
                                <option {{ Request('kode_dept')==$item->kode_dept ? 'selected':'' }} value="{{ $item->kode_dept }}">{{ $item->nama_dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary" id="savedept">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#editForm');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validate your form inputs here if needed

            // Submit the form using AJAX
            axios.post('{{ route("editkaryawan") }}', new FormData(form))
                .then(function (response) {
                    // Handle success
                    Swal.fire('Success', 'Data berhasil Diupdate', 'success');
                       // Redirect to the datakaryawan route
                       window.location.href = '{{ route("datakaryawan") }}';
                })
                .catch(function (error) {
                    // Handle errors if any
                    console.error('Error submitting form', error);
                });
        });
    });
    $(document).ready(function(){
        $('#datepicker').datepicker();

        $("#tempat_tanggal_lahir").change(function(e){
            var tempat_tanggal_lahir = $(this).val();
            console.log("Selected date: " + tempat_tanggal_lahir);

            $.ajax({
                type: 'POST',
                url: '/getpresensi',
                data: {
                    _token: "{{ csrf_token() }}",
                    tempat_tanggal_lahir: tempat_tanggal_lahir
                },
                cache: false,
                success: function(response){
                    console.log("AJAX Success!");
                    console.log(response);
                    $("#loadpresensi").html(response);
                },
                error: function(xhr, status, error){
                    console.error("AJAX Error!");
                    console.error(xhr.responseText);
                }
            });
        });

        // Test if this part is executed
        console.log("JavaScript loaded successfully");
    });
</script>
@include('layouts.footer')
@include('layouts.script')
@endsection
