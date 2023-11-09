@extends('layouts.sidebar')

@section('container')
<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 400px; /* Tinggi peta disesuaikan untuk menampilkan semua lingkaran */
    }
</style>
<div class="row" style="margin-top: 50px">
    <div class="col">
        <input type="text" id="lokasi">
        <div class="webcam-capture"></div>
    </div>
</div>
<div class="row">
    <div class="col">
        <button id="takeabsen" class="btn btn-danger btn-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 512 512"><path fill="none"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                    d="m350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32Z" /><circle
                    cx="256" cy="272" r="80" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" /><path
                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                    d="M124 158v-22h-24v22" /></svg>
            @if ($cek > 0)
            absen pulang
            @else
            absen masuk
            @endif
        </button>
    </div>
</div>
<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
<audio id="notif_in">
    <source src="{{ asset('assets/sound/notif.mp3') }}" type="audio/mpeg">
</audio>
<audio id="notif_out">
    <source src="{{ asset('assets/sound/notif_out.mp3') }}" type="audio/mpeg">
</audio>
<audio id="radius">
    <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
</audio>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Inisialisasi Webcam.js setelah halaman dimuat
    var notif_in = document.getElementById('notif_in');
    var notif_out = document.getElementById('notif_out');
    var radius = document.getElementById('radius');
    document.addEventListener("DOMContentLoaded", function () {
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('.webcam-capture');
    });

    if ("geolocation" in navigator) {
        // Geolokasi tersedia
        navigator.geolocation.getCurrentPosition(function (position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var lokasi = document.getElementById("lokasi");
            lokasi.value = latitude + "," + longitude;
            var map = L.map('map').setView([latitude, longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([latitude, longitude]).addTo(map);

            var circleCoordinates = []; // Untuk menyimpan koordinat situs di dalam lingkaran

            @foreach ($sites as $site)
                var latsite = {{ $site->latitude }};
                var longsite = {{ $site->longitude }};
                var circle = L.circle([latsite, longsite], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 50
                }).addTo(map);

                // Periksa apakah pengguna berada dalam lingkaran
                if (isUserWithinCircle(latitude, longitude, latsite, longsite, 50)) {
                    circleCoordinates.push({ latitude: latsite, longitude: longsite });
                }
            @endforeach

            // Gunakan circleCoordinates untuk menampilkan hanya koordinat situs yang relevan
            console.log(circleCoordinates);
        });
    } else {
        // Geolokasi tidak tersedia di browser pengguna
        console.log("Geolokasi tidak tersedia.");
    }

    // Fungsi untuk memeriksa apakah koordinat pengguna berada dalam lingkaran
    function isUserWithinCircle(userLat, userLng, circleLat, circleLng, radius) {
        var distance = Math.sqrt(Math.pow(userLat - circleLat, 2) + Math.pow(userLng - circleLng, 2));
        return distance <= radius;
    }

    document.getElementById("takeabsen").addEventListener("click", function (e) {
        // Pastikan Webcam.js sudah dimuat sebelum mengambil gambar
        Webcam.snap(function (image) {
            // Menggunakan callback untuk mendapatkan gambar
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: '{{ csrf_token() }}',
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function (response) {
                    var status = response.split("|");
                    // Tindakan setelah permintaan AJAX berhasil
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notif_in.play();
                        } else {
                            notif_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success',
                        });
                        setTimeout(function () {
                            window.location.href = '/home';
                        }, 3000);
                    } else {
                        if (status[2] == "radius") {
                            notif_in.play();
                        } else {
                            radius.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Tindakan jika permintaan AJAX gagal
                    console.error(error);
                }
            });
        });
    });
</script>

@include('layouts.script')
@endsection
