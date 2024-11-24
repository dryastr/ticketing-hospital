@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Jumlah Dokter</h4>
                </div>
                <div class="card-body text-center">
                    <h3>{{ $jumlahDokter }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Jumlah Pasien</h4>
                </div>
                <div class="card-body text-center">
                    <h3>{{ $jumlahPasien }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Total Antrian</h4>
                </div>
                <div class="card-body text-center">
                    <h3>{{ $totalAntrian }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
