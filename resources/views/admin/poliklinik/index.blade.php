@extends('layouts.main')

@section('title', 'Poliklinik')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Daftar Poliklinik</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addPoliklinikModal">
                            Tambah Poliklinik Baru
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Poliklinik</th>
                                        <th>Nama Poliklinik</th>
                                        <th>Dokter</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($polikliniks as $poliklinik)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $poliklinik->kode_poli }}</td>
                                            <td>{{ $poliklinik->nama_poli }}</td>
                                            <td>{{ $poliklinik->dokter?->name ?? 'Belum Ada' }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $poliklinik->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $poliklinik->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#editPoliklinikModal"
                                                                onclick="editPoliklinik({{ json_encode($poliklinik) }})">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('poliklinik.destroy', $poliklinik->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus poliklinik ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Hapus</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
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

    <div class="modal fade" id="addPoliklinikModal" tabindex="-1" aria-labelledby="addPoliklinikModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPoliklinikModalLabel">Tambah Poliklinik Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('poliklinik.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode_poli" class="form-label">Kode Poliklinik</label>
                            <input type="text" class="form-control" id="kode_poli" name="kode_poli" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_poli" class="form-label">Nama Poliklinik</label>
                            <input type="text" class="form-control" id="nama_poli" name="nama_poli" required>
                        </div>
                        <div class="mb-3">
                            <label for="dokter_id" class="form-label">Dokter</label>
                            <select class="form-control" id="dokter_id" name="dokter_id">
                                <option value="">Pilih Dokter</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPoliklinikModal" tabindex="-1" aria-labelledby="editPoliklinikModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPoliklinikModalLabel">Ubah Poliklinik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPoliklinikForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_kode_poli" class="form-label">Kode Poliklinik</label>
                            <input type="text" class="form-control" id="edit_kode_poli" name="kode_poli" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_poli" class="form-label">Nama Poliklinik</label>
                            <input type="text" class="form-control" id="edit_nama_poli" name="nama_poli" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_dokter_id" class="form-label">Dokter</label>
                            <select class="form-control" id="edit_dokter_id" name="dokter_id">
                                <option value="">Pilih Dokter</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function editPoliklinik(poliklinik) {
            document.getElementById('editPoliklinikForm').action = `/poliklinik/${poliklinik.id}`;
            document.getElementById('edit_kode_poli').value = poliklinik.kode_poli;
            document.getElementById('edit_nama_poli').value = poliklinik.nama_poli;
            document.getElementById('edit_dokter_id').value = poliklinik.dokter_id || '';
            $('#editPoliklinikModal').modal('show');
        }
    </script>
@endpush
