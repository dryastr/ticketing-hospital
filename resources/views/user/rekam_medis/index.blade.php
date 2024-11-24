@extends('layouts.main')

@section('title', 'Rekam Medis Pasien')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Daftar Rekam Medis</h4>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rekamMedis as $index => $rekam)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $rekam->pasien->nomor_rekam_medis ?? 'Belum Ada' }}</td>
                                            <td>{{ $rekam->tanggal_waktu_pemeriksaan }}</td>
                                            <td>{{ Str::limit($rekam->keluhan, 50) }}</td>
                                            <td>{{ Str::limit($rekam->hasil_diagnosa, 50) }}</td>
                                            <td>{{ Str::limit($rekam->tindakan_pengobatan, 50) }}</td>
                                            <td>{{ Str::limit($rekam->resep_dokter, 50) }}</td>
                                            <td>{{ $rekam->dokter->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $rekam->id }}">
                                                    Detail
                                                </button>
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

    @foreach ($rekamMedis as $rekam)
        <div class="modal fade" id="detailModal{{ $rekam->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Rekam Medis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nomor Rekam Medis:</strong>
                                <p>{{ $rekam->pasien->nomor_rekam_medis }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal Pemeriksaan:</strong>
                                <p>{{ $rekam->tanggal_waktu_pemeriksaan }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Keluhan:</strong>
                                <p>{{ $rekam->keluhan }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Hasil Diagnosa:</strong>
                                <p>{{ $rekam->hasil_diagnosa }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Tindakan Pengobatan:</strong>
                                <p>{{ $rekam->tindakan_pengobatan }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Resep Dokter:</strong>
                                <p>{{ $rekam->resep_dokter }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Dokter:</strong>
                                <p>{{ $rekam->dokter->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
