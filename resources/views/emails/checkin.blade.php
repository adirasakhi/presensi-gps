<!-- resources/views/emails/presensi.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Hari Ini</title>
</head>
<body>
    <h2>Presensi Hari Ini</h2>

    <p>Berikut adalah data presensi hari ini:</p>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nik</th>
                <th>Nama</th>
                <th>Tanggal Presensi</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensiData as $presensi)
                <tr>
                    <td>{{ $presensi->nik }}</td>
                    <td>{{ $presensi->name }}</td>
                    <td>{{ $presensi->tgl_presensi }}</td>
                    <td>{{ $presensi->jam_in }}</td>
                    <td>{{ $presensi->jam_out }}</td>
                    <td>{{ $presensi->detail }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Terima kasih.</p>
</body>
</html>
