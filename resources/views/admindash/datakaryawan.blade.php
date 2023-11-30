@extends('layouts.sidebaradmin')
@section('title', 'Karyawan')
@section('container')
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <div class="page-title">
                Data Karyawan
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <!-- Button to trigger the modal -->
                                <a href="{{ route('tambahkaryawan') }}" class="btn btn-danger">

<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#eeeeec}</style><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                                    Tambah Data
                                </a>
                            </div>
                            <div class="col-12">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="Nama Karyawan" value="{{ Request('name') }}">
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#eeeeec}</style><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nik</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Plat Kendaraan</th>
                                                <th>perusahaan</th>
                                                <th>No. Telp</th>
                                                <th>Foto</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                    <td>{{ $item->nik }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->jabatan }}</td>
                                                    <td>{{ $item->plat_no }}</td>
                                                    <td>{{ $item->perusahaan }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>
                                                        @if ($item->foto != null)
                                                            <img src="{{ asset('profile_images/' . $item->nik . '.png') }}" class="avatar" alt="" style="width: 40px; height: 40px;">
                                                        @else
                                                            <img src="{{ asset('profile_images/default.svg') }}" alt="Default Profile Image" style="width: 40px;">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">

                                                                 <form action="{{ route('delete', ['nik' => $item->nik]) }}" method="POST">
                                                                @csrf
                                                                <a href="{{ route('delete', ['nik' => $item->nik]) }}" class="btn btn-danger ml-2 delete-karyawan" data-nik="{{ $item->nik }}" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#eeeeec}</style><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                                                                </a>
                                                            </form>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // When the "Delete" anchor is clicked
    $(document).on('click', '.delete-karyawan', function(e) {
        var form = $(this).closest('form');
        e.preventDefault(); // Prevent the default link behavior
        Swal.fire({
            title: 'Apakah kamu yakin',
            showCancelButton: true,
            confirmButtonText: 'Delete',
        }).then((result)=>
        {
            if(result.isConfirmed){
                form.submit();
                Swal.fire('Saved','','success')
            }
        })

    });
</script>



@endsection
