<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-danger">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="{{asset('assets/img/aa.jpeg')}}" alt="" srcset="">
                                    </div>
                                    <form class="user" method="POST" action="{{ route('register.proses') }}" id="registration-form">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="name" id="name" placeholder="Nama Lengkap" value="{{old('name')}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control form-control-user" name="nik" id="nik" placeholder="Id Card/ KTP" min="0" value="{{old('nik')}}">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="jabatan" id="jabatan" placeholder="Jabatan" min="0" value="{{old('jabatan')}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_kelamin" style="margin-left: 10px">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" style="margin-left: 120px">
                                                    <option value="laki-laki">laki-laki</option>
                                                    <option value="perempuan">perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tempat_tanggal_lahir">Tanggal Lahir</label>
                                            <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                                                <input class="form-control" type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" >
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="phone" id="phone" placeholder="No Telp" min="0" value="{{old('phone')}}">
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
                                                    <div></div>
                                                    <input type="email" class="form-control form-control-user" name="email" id="email" placeholder="Email" value="{{old('email')}}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                                                </div>

                                        <button type="submit" class="btn btn-danger btn-user btn-block" id="registration-button">
                                            Buat
                                        </button>
                                        <hr>
                                    </form>
                                    <!-- Pesan Kesalahan -->
                                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    <!-- Include Bootstrap Datepicker CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        // Validasi di sisi klien
        document.getElementById('registration-form').addEventListener('submit', function (event) {
            var nama = document.getElementById('nama').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var nik = document.getElementById('nik').value;
            var errorMessage = document.getElementById('error-message');

            errorMessage.style.display = 'none'; // Sembunyikan pesan kesalahan sebelumnya

            if (!nama || !email || !password || !nik) {
                errorMessage.innerHTML = 'Semua kolom harus diisi.';
                errorMessage.style.display = 'block';
                event.preventDefault(); // Mencegah pengiriman formulir jika ada kesalahan
            }
        });
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
</body>
</html>
