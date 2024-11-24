@extends('layouts.main')

@section('title', 'Daftar Antrian')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="">
                        <h4 class="card-title">Daftar Antrian</h4>
                        <span class="pb-5">Hai, {{ auth()->user()->name }}</span>
                    </div>
                </div>
                <div class="card-content pt-0">
                    <div class="card-body pt-0">

                        <div class="row mb-3 pt-0">
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-between">
                                    @forelse ($antrians->where('status', 'waiting')->take(3) as $antrian)
                                        <div class="card text-center mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Nomor Antrian</h5>
                                                <p class="card-text display-4">{{ $antrian->nomor_antrian }}</p>
                                                <p class="text-muted">Status: {{ ucfirst($antrian->status) }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center w-100">Tidak ada antrian berikutnya.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        @php
                            $lastAntrian = \App\Models\Antrian::latest('nomor_antrian')->first();
                            $nextAntrianNumber = $lastAntrian ? $lastAntrian->nomor_antrian + 1 : 1;
                        @endphp

                        <div class="alert alert-info">
                            Nomor antrian Anda berikutnya adalah: <strong>{{ $nextAntrianNumber }}</strong>
                        </div>

                        <form action="{{ route('antrian.create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="poliklinik_id">Pilih Poliklinik</label>
                                <select name="poliklinik_id" id="poliklinik_id" class="form-control">
                                    @foreach (\App\Models\Poliklinik::all() as $poliklinik)
                                        <option value="{{ $poliklinik->id }}">{{ $poliklinik->nama_poli }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Mendaftar Antrian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
