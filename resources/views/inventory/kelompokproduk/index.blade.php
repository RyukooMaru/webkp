@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Kelompok Produk</h1>
    <p class="mb-4">Manajemen Daftar Kelompok Produk untuk aplikasi.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Add New Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addKelompokModal">
            <i class="fas fa-plus"></i> Tambah Kelompok Produk
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kelompok Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kelompok Produk</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompokProduks as $index => $kelompok)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kelompok->nama_kelompok }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $kelompok->id }}"
                                    data-nama="{{ $kelompok->nama_kelompok }}"
                                    data-toggle="modal" 
                                    data-target="#editKelompokModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $kelompok->id }}"
                                    data-nama="{{ $kelompok->nama_kelompok }}"
                                    data-toggle="modal" 
                                    data-target="#deleteKelompokModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addKelompokModal" tabindex="-1" aria-labelledby="addKelompokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKelompokModalLabel">Tambah Kelompok Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kelompokproduk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kelompok">Nama Kelompok Produk</label>
                        <input type="text" class="form-control" id="nama_kelompok" name="nama_kelompok" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editKelompokModal" tabindex="-1" aria-labelledby="editKelompokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKelompokModalLabel">Edit Kelompok Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama">Nama Kelompok Produk</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama_kelompok" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteKelompokModal" tabindex="-1" aria-labelledby="deleteKelompokModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteKelompokModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong id="delete_nama"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('kelompokproduk.update', ':id') }}".replace(':id', id);
            
            $('#editForm').attr('action', url);
            $('#edit_nama').val($(this).data('nama'));
        });

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('kelompokproduk.destroy', ':id') }}".replace(':id', id);
            var nama = $(this).data('nama');
            
            $('#deleteForm').attr('action', url);
            $('#delete_nama').text(nama);
        });
    });
</script>
@endsection