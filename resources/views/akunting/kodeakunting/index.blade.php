@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-light">
            <h5>Daftar Kode Akuntansi</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-primary btn-sm" id="tambahData">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                <button class="btn btn-success btn-sm" id="ubahData">
                    <i class="fas fa-edit"></i> Ubah Data
                </button>
                <button class="btn btn-danger btn-sm" id="hapusData">
                    <i class="fas fa-trash"></i> Hapus Data
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="table-kode-akuntansi">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Akun</th>
                            <th width="20%">Perkiraan</th>
                            <th width="15%">Klasifikasi</th>
                            <th width="15%">Sub Klasifikasi</th>
                            <th width="10%">Cash / Bank</th>
                            <th width="5%">D / K</th>
                            <th width="10%">Pengguna</th>
                            <th width="10%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kodeAkuntansi as $index => $kode)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kode->akun }}</td>
                            <td>{{ $kode->perkiraan }}</td>
                            <td>{{ $kode->klasifikasi }}</td>
                            <td>{{ $kode->sub_klasifikasi }}</td>
                            <td>{{ $kode->cash_bank }}</td>
                            <td>{{ $kode->d_k }}</td>
                            <td>{{ $kode->pengguna }}</td>
                            <td>{{ \Carbon\Carbon::parse($kode->tanggal)->format('d F Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="mx-2">Page 1 of 5</span>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div>
                    <span>Displaying 1 to 20 of 83 items</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalKodeAkuntansi" tabindex="-1" aria-labelledby="modalKodeAkuntansiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKodeAkuntansiLabel">Tambah Kode Akuntansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formKodeAkuntansi" action="{{ route('kodeakuntansi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="akun" class="form-label">Akun</label>
                        <input type="text" class="form-control" id="akun" name="akun" required>
                    </div>
                    <div class="mb-3">
                        <label for="perkiraan" class="form-label">Perkiraan</label>
                        <input type="text" class="form-control" id="perkiraan" name="perkiraan" required>
                    </div>
                    <div class="mb-3">
                        <label for="klasifikasi" class="form-label">Klasifikasi</label>
                        <input type="text" class="form-control" id="klasifikasi" name="klasifikasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_klasifikasi" class="form-label">Sub Klasifikasi</label>
                        <input type="text" class="form-control" id="sub_klasifikasi" name="sub_klasifikasi">
                    </div>
                    <div class="mb-3">
                        <label for="cash_bank" class="form-label">Cash/Bank</label>
                        <input type="text" class="form-control" id="cash_bank" name="cash_bank">
                    </div>
                    <div class="mb-3">
                        <label for="d_k" class="form-label">D/K</label>
                        <select class="form-select" id="d_k" name="d_k" required>
                            <option value="Debet">Debet</option>
                            <option value="Kredit">Kredit</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle tambah data
        $('#tambahData').click(function() {
            $('#modalKodeAkuntansiLabel').text('Tambah Kode Akuntansi');
            $('#formKodeAkuntansi').attr('action', '{{ route("kodeakuntansi.store") }}');
            $('#formKodeAkuntansi')[0].reset();
            $('#modalKodeAkuntansi').modal('show');
        });

        // Disini Anda bisa tambahkan JavaScript untuk edit dan hapus data
    });
</script>
@endsection
