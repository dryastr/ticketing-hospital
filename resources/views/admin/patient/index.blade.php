@extends('layouts.main')

@section('title', 'Pasien')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Daftar Pasien</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                            Tambah Pasien Baru
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl" style="padding-top: 2rem">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Rekam Medis</th>
                                        <th>Nama Pasien</th>
                                        <th>Alamat</th>
                                        <th>Rekam Medis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $patient)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $patient->nomor_rekam_medis }}</td>
                                            <td>{{ $patient->user->name }}</td>
                                            <td>{{ $patient->alamat }}</td>
                                            <td class="">
                                                @if ($patient->user)
                                                    <a href="{{ route('pasien.showByUser', $patient->user->id) }}"
                                                        class="btn btn-info">
                                                        Lihat Rekam Medis
                                                    </a>
                                                @else
                                                    <button class="btn btn-secondary" disabled>Data Tidak Tersedia</button>
                                                @endif
                                                <a href="{{ route('pasien.printRekamMedis', $patient->id) }}"
                                                    class="btn btn-primary">
                                                    Cetak Rekam Medis
                                                </a>
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $patient->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $patient->id }}">
                                                        <li>
                                                            <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#editPatientModal"
                                                                onclick="editPatient({{ json_encode($patient) }})">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#viewPatientDetailModal"
                                                                onclick="viewPatientDetail({{ json_encode($patient) }})">Lihat
                                                                Detail</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('pasien.destroy', $patient->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
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

    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Ubah Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPatientForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nomor_rekam_medis" class="form-label">Nomor Rekam Medis</label>
                            <input type="text" class="form-control" id="edit_nomor_rekam_medis" name="nomor_rekam_medis"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="edit_nama_pasien" name="nama_pasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tempat_tanggal_lahir" class="form-label">Tempat & Tanggal Lahir</label>
                            <input type="text" class="form-control" id="edit_tempat_tanggal_lahir"
                                name="tempat_tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status_perkawinan" class="form-label">Status Perkawinan</label>
                            <input type="text" class="form-control" id="edit_status_perkawinan"
                                name="status_perkawinan" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kontak_keluarga_terdekat" class="form-label">Kontak Keluarga Terdekat</label>
                            <input type="text" class="form-control" id="edit_kontak_keluarga_terdekat"
                                name="kontak_keluarga_terdekat">
                        </div>
                        <div class="mb-3">
                            <label for="edit_pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" id="edit_pekerjaan" name="pekerjaan">
                        </div>
                        <div class="mb-3">
                            <label for="edit_pendidikan" class="form-label">Pendidikan</label>
                            <input type="text" class="form-control" id="edit_pendidikan" name="pendidikan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewPatientDetailModal" tabindex="-1" aria-labelledby="viewPatientDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPatientDetailModalLabel">Detail Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="viewPatientDetailForm">
                        @csrf
                        <div class="mb-3">
                            <label for="view_nomor_rekam_medis" class="form-label">Nomor Rekam Medis</label>
                            <input type="text" class="form-control" id="view_nomor_rekam_medis" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_user_id" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="view_user_id" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="view_alamat" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_tempat_tanggal_lahir" class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control" id="view_tempat_tanggal_lahir" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="view_jenis_kelamin" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_status_perkawinan" class="form-label">Status Perkawinan</label>
                            <input type="text" class="form-control" id="view_status_perkawinan" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_kontak_keluarga_terdekat" class="form-label">Kontak Keluarga Terdekat</label>
                            <input type="text" class="form-control" id="view_kontak_keluarga_terdekat" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_pekerjaan" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" id="view_pekerjaan" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="view_pendidikan" class="form-label">Pendidikan</label>
                            <input type="text" class="form-control" id="view_pendidikan" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        function editPatient(patient) {
            console.log(patient);
            document.getElementById('editPatientForm').action = '/pasien/' + patient.id;
            document.getElementById('edit_nomor_rekam_medis').value = patient.nomor_rekam_medis;
            document.getElementById('edit_nama_pasien').value = patient.nama_pasien;
            document.getElementById('edit_alamat').value = patient.alamat;
            document.getElementById('edit_tempat_tanggal_lahir').value = patient.tempat_tanggal_lahir;
            document.getElementById('edit_jenis_kelamin').value = patient.jenis_kelamin;
            document.getElementById('edit_status_perkawinan').value = patient.status_perkawinan;
            document.getElementById('edit_kontak_keluarga_terdekat').value = patient.kontak_keluarga_terdekat;
            document.getElementById('edit_pekerjaan').value = patient.pekerjaan;
            document.getElementById('edit_pendidikan').value = patient.pendidikan;
        }
    </script>
    <script>
        function viewPatientDetail(patient) {
            document.getElementById('view_nomor_rekam_medis').value = patient.nomor_rekam_medis;
            document.getElementById('view_user_id').value = patient.user.name;
            document.getElementById('view_alamat').value = patient.alamat;
            document.getElementById('view_tempat_tanggal_lahir').value = patient.tempat_tanggal_lahir;
            document.getElementById('view_jenis_kelamin').value = patient.jenis_kelamin;
            document.getElementById('view_status_perkawinan').value = patient.status_perkawinan;
            document.getElementById('view_kontak_keluarga_terdekat').value = patient.kontak_keluarga_terdekat;
            document.getElementById('view_pekerjaan').value = patient.pekerjaan;
            document.getElementById('view_pendidikan').value = patient.pendidikan;
        }
    </script>
@endpush
