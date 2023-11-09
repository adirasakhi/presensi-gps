@foreach ($presensi as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->name }}</td>
        <td>{{ $d->nama_dept }}</td>
        <td>{{ $d->lokasi_in }}</td>
        <td>{{ $d->jam_in }}</td>
        <td>{{ $d->jam_out }}</td>
        <td>
            <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}" alt="Foto Mulai"
                width="100">
        </td>
        <td>
            <img src="{{ asset('storage/uploads/absensi/' . $d->foto_out) }}"
                alt="Foto Selesai" width="100">
    </tr>
@endforeach
