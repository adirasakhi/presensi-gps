@extends('layouts.sidebaradmin')
@section('title', 'Dashboard')

@section('container')
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-title">
                Dashboard
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="card card-sm mr-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-fingerprint" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Actual SVG Path Data -->
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                {{ $rekappresensi->jmlhadir ?? 'N/A' }}
                            </div>
                            <div class="text-secondary">
                                Karyawan Masuk Site
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <!--    Actual SVG Path Data -->
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                {{ $jmlkaryawan->jmlkaryawan ?? 'N/A' }}
                            </div>
                            <div class="text-secondary">
                                Karyawan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-sm mt-2">
            <div class="card-body">
                <canvas id="attendanceChart" width="50px" height="25px"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the daily attendance data from PHP
    var dailyAttendance = {{ $rekappresensi->jmlhadir ?? 0 }};

    // Get the monthly attendance data from PHP
    var monthlyAttendanceData = {!! json_encode($monthlyAttendance) !!};

    // Extract dates and attendance counts for the monthly data
    var monthlyLabels = monthlyAttendanceData.map(function (data) {
        return data.tanggal;
    });

    var monthlyAttendanceCounts = monthlyAttendanceData.map(function (data) {
        return data.jmlhadir;
    });

    // Access the canvas element
    var ctx = document.getElementById('attendanceChart').getContext('2d');

    // Create the chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Daily', ...monthlyLabels],
            datasets: [{
                label: 'Rekap Dalam Diagram ',
                data: [dailyAttendance, ...monthlyAttendanceCounts],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', ...Array(monthlyAttendanceCounts.length).fill('rgba(54, 162, 235, 0.2)')],
                borderColor: ['rgba(75, 192, 192, 1)', ...Array(monthlyAttendanceCounts.length).fill('rgba(54, 162, 235, 1)')],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
