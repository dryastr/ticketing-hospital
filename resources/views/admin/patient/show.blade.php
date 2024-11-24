@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="">
                        <h4 class="card-title">Rekam Medis Pasien: {{ $user->name }}</h4>
                        <strong>Nomor Rekam Medis:</strong> {{ $pasien->nomor_rekam_medis }}
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($rekamMedis->isEmpty())
                                <p class="text-center">Data Rekam Medis tidak ditemukan.</p>
                            @else
                                <table class="table table-xl" style="padding-top: 2rem">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal Pemeriksaan</th>
                                            <th>Keluhan</th>
                                            <th>Hasil Diagnosa</th>
                                            <th>Tindakan Pengobatan</th>
                                            <th>Resep Dokter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rekamMedis as $index => $rekam)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $rekam->tanggal_waktu_pemeriksaan }}</td>
                                                <td>{{ $rekam->keluhan }}</td>
                                                <td>{{ $rekam->hasil_diagnosa }}</td>
                                                <td>{{ $rekam->tindakan_pengobatan }}</td>
                                                <td>{{ $rekam->resep_dokter }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
