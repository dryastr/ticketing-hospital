@extends('layouts.main')

@section('title', 'Rekam Medis')

@push('header-styles')
    <style>
        .pointer-events-none {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">
                            Rekam Medis Pasien | Antrian Nomor
                            @if ($antrian->status === 'done')
                                {{ $nextAntrian ? $nextAntrian->nomor_antrian - 1 : $antrian->nomor_antrian }}
                            @else
                                {{ $antrian->nomor_antrian }}
                            @endif
                        </h4>
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rekamMedisModal">
                                Tambahkan Rekam Medis
                            </button>
                            @if ($nextAntrian && !$isLastAntrian)
                                <a href="{{ route('rekam_medis.show', ['pasienId' => $nextAntrian->pasien_id, 'antrian' => $nextAntrian->id]) }}"
                                    class="btn {{ $antrian->status === 'waiting' ? 'btn-secondary disabled pointer-events-none' : 'btn-primary' }}"
                                    {{ $antrian->status === 'waiting' ? 'disabled pointer-events-none' : '' }}>
                                    Ambil Antrian Nomor
                                    @if ($antrian->status === 'done')
                                        {{ $nextAntrian ? $nextAntrian->nomor_antrian : $antrian->nomor_antrian }}
                                    @else
                                        {{ $antrian->nomor_antrian + 1 }}
                                    @endif
                                </a>
                            @elseif ($isLastAntrian)
                                <span class="text-muted">Tidak ada antrian berikutnya</span>
                            @else
                                <p>Tidak ada antrian saat ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Data Pasien</h5>
                        <p><strong>Nama:</strong> {{ $pasien->user->name }}</p>
                        <p><strong>Alamat:</strong> {{ $pasien->alamat ?? '-' }}</p>
                        <p><strong>Tanggal Lahir:</strong> {{ $pasien->tempat_tanggal_lahir ?? '-' }}</p>
                        <p><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin ?? '-' }}</p>
                        <p><strong>Status Perkawinan:</strong> {{ $pasien->status_perkawinan ?? '-' }}</p>
                        <p><strong>Kontak Keluarga Terdekat:</strong>
                            {{ $pasien->kontak_keluarga_terdekat ?? '-' }}
                        </p>
                        <p><strong>Pekerjaan:</strong> {{ $pasien->pekerjaan ?? '-' }}</p>
                        <p><strong>Pendidikan:</strong> {{ $pasien->pendidikan ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Riwayat Rekam Medis</h5>
                        @if ($rekamMedis->isEmpty())
                            <p>Belum ada data rekam medis.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($rekamMedis as $medis)
                                    <li class="list-group-item">
                                        <p><strong>Tanggal:</strong> {{ $medis->tanggal_waktu_pemeriksaan }}</p>
                                        <p><strong>Keluhan:</strong> {{ $medis->keluhan }}</p>
                                        <p><strong>Hasil Diagnosa:</strong> {{ $medis->hasil_diagnosa }}</p>
                                        <p><strong>Tindakan Pengobatan:</strong> {{ $medis->tindakan_pengobatan }}</p>
                                        <p><strong>Resep Dokter:</strong> {{ $medis->resep_dokter }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="modal fade" id="rekamMedisModal" tabindex="-1" aria-labelledby="rekamMedisModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rekamMedisModalLabel">Form Rekam Medis</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('rekam-medis-management.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                                            <input type="hidden" name="antrian_id"
                                                value="{{ $antrian ? $antrian->id : '' }}">

                                            <div class="mb-3">
                                                <label for="tanggal_waktu_pemeriksaan" class="form-label">Tanggal
                                                    Pemeriksaan</label>
                                                <input type="datetime-local" class="form-control"
                                                    name="tanggal_waktu_pemeriksaan" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keluhan" class="form-label">Keluhan</label>
                                                <textarea class="form-control" name="keluhan" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hasil_diagnosa" class="form-label">Hasil Diagnosa</label>
                                                <textarea class="form-control" name="hasil_diagnosa" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tindakan_pengobatan" class="form-label">Tindakan
                                                    Pengobatan</label>
                                                <textarea class="form-control" name="tindakan_pengobatan" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="resep_dokter" class="form-label">Resep Dokter</label>
                                                <textarea class="form-control" name="resep_dokter" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" name="dokter_id" value="{{ auth()->user()->id }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
