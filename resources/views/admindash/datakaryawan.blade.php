@extends('layouts.sidebaradmin')

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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 14 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M9 12h6"></path>
                                        <path d="M12 9v6"></path>
                                    </svg>
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
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_dept" id="kode_dept" class="form-control">
                                                    <option value="">Departemen</option>
                                                    @foreach ($departemen as $item)
                                                        <option {{ Request('kode_dept') == $item->kode_dept ? 'selected' : '' }} value="{{ $item->kode_dept }}">{{ $item->nama_dept }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 0 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg>
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
                                                <th>Departement</th>
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
                                                    <td>{{ $item->nama_dept }}</td>
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
                                                            <a href="{{ route('editdatakaryawan', ['nik' => $item->nik]) }}" class="btn btn-primary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                                    <path d="M16 5l3 3"></path>
                                                                 </svg></a>
                                                                 <form action="{{ route('delete', ['nik' => $item->nik]) }}" method="POST">
                                                                @csrf
                                                                <a href="{{ route('delete', ['nik' => $item->nik]) }}" class="btn btn-danger ml-2 delete-karyawan" data-nik="{{ $item->nik }}" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                        <path d="M4 7l16 0"></path>
                                                                        <path d="M10 11l0 6"></path>
                                                                        <path d="M14 11l0 6"></path>
                                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                                     </svg>
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
