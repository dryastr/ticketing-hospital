<!DOCTYPE html>
<html>

<head>
    <title>Rekam Medis Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        .patient-info {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <h1>Laporan Rekam Medis Pasien</h1>

    <div class="patient-info">
        <h2>Identitas Pasien</h2>
        <p><strong>Nama:</strong> {{ $patient->user->name }}</p>
        <p><strong>Nomor Rekam Medis:</strong> {{ $patient->nomor_rekam_medis }}</p>
        <p><strong>Email:</strong> {{ $patient->user->email }}</p>
        <p><strong>Alamat:</strong> {{ $patient->alamat }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $patient->jenis_kelamin }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ $patient->tanggal_lahir }}</p>
        <p><strong>Nomor Telepon:</strong> {{ $patient->nomor_telepon }}</p>
    </div>

    <h2>Riwayat Rekam Medis</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal Pemeriksaan</th>
                <th>Keluhan</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Resep</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patient->rekamMedis as $rekam)
                <tr>
                    <td>{{ $rekam->tanggal_waktu_pemeriksaan }}</td>
                    <td>{{ $rekam->keluhan }}</td>
                    <td>{{ $rekam->hasil_diagnosa }}</td>
                    <td>{{ $rekam->tindakan_pengobatan }}</td>
                    <td>{{ $rekam->resep_dokter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
