@extends('layouts.main')

@section('title', 'Dashboard Dokter')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dashboard Dokter</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        @if ($nextAntrian)
                            <p>Nomor Antrian Saat Ini: <strong>{{ $nextAntrian->nomor_antrian }}</strong></p>
                            <a href="{{ route('rekam_medis.show', ['pasienId' => $nextAntrian->pasien_id, 'antrian' => $nextAntrian->id]) }}"
                                class="btn btn-primary">
                                Ambil Antrian Nomor {{ $nextAntrian->nomor_antrian }}
                            </a>
                        @else
                            <p>Tidak ada antrian saat ini.</p>
                        @endif
                    </div>

                    <div class="row mb-3 pt-0">
                        <div class="col-12">
                            <h5 class="mb-3">Nomor Antrian Berikutnya</h5>
                            <div class="d-flex flex-wrap justify-content-between">
                                @forelse ($nextThreeAntrians as $antrian)
                                    <div class="card text-center mb-3" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Nomor Antrian</h5>
                                            <p class="card-text display-4">{{ $antrian->nomor_antrian }}</p>
                                            <p class="text-muted">Status: {{ ucfirst($antrian->status) }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">Tidak ada antrian berikutnya.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
