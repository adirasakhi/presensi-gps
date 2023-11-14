@extends('layouts.sidebaradmin')
@section('title', 'Monitoring')
@section('container')
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-title">
                Monitoring
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <label>Pilih Tanggal: </label>
                <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                    <input class="form-control" type="text" id="tanggal" name="tanggal">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nik</th>
                        <th>Nama</th>
                        <th>Departement</th>
                        <th>Lokasi</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Foto Mulai</th>
                        <th>Foto Selesai</th>
                    </tr>
                </thead>

                <tbody id="loadpresensi"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Bootstrap Datepicker CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function(){
        $('#datepicker').datepicker();

        $("#tanggal").change(function(e){
            var tanggal = $(this).val();
            console.log("Selected date: " + tanggal);

            $.ajax({
                type: 'POST',
                url: '/getpresensi',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal
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


@endsection
