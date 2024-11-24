@extends('layouts.main')

@section('title', 'Rekam Medis')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rekam Medis Pasien</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Data Pasien</h5>
                        <p>Nama: {{ $pasien->nama }}</p>
                        <p>Alamat: {{ $pasien->alamat }}</p>
                        <p>Nomor Rekam Medis: {{ $pasien->nomor_rekam_medis }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Riwayat Rekam Medis</h5>
                        @if ($rekamMedis->isEmpty())
                            <p>Belum ada data rekam medis.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($rekamMedis as $medis)
                                    <li class="list-group-item">
                                        <p>Tanggal: {{ $medis->tanggal_waktu_pemeriksaan }}</p>
                                        <p>Keluhan: {{ $medis->keluhan }}</p>
                                        <p>Hasil Diagnosa: {{ $medis->hasil_diagnosa }}</p>
                                        <p>Tindakan Pengobatan: {{ $medis->tindakan_pengobatan }}</p>
                                        <p>Resep Dokter: {{ $medis->resep_dokter }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
