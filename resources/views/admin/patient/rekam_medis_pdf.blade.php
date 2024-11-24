<!DOCTYPE html>
<html>

<head>
    <title>Rekam Medis Semua Pasien</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h1>Laporan Rekam Medis Pasien</h1>
    @foreach ($patients as $patient)
        <h2>Pasien: {{ $patient->user->name }}</h2>
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
    @endforeach
</body>

</html>
