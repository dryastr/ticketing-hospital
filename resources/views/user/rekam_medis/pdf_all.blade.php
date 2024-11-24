<!DOCTYPE html>
<html>

<head>
    <title>Rekam Medis Semua Pasien</title>
</head>

<body>
    <h1>Rekam Medis Pasien</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Rekam Medis</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Keluhan</th>
                <th>Hasil Diagnosa</th>
                <th>Tindakan Pengobatan</th>
                <th>Resep Dokter</th>
                <th>Dokter</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $index => $rekam)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rekam->pasien->nomor_rekam_medis }}</td>
                    <td>{{ $rekam->tanggal_waktu_pemeriksaan }}</td>
                    <td>{{ $rekam->keluhan }}</td>
                    <td>{{ $rekam->hasil_diagnosa }}</td>
                    <td>{{ $rekam->tindakan_pengobatan }}</td>
                    <td>{{ $rekam->resep_dokter }}</td>
                    <td>{{ $rekam->dokter_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
