@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Satuan Produk (UOM)</h1>
    <p class="mb-4">Manajemen Unit of Measure untuk aplikasi.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSatuanModal">
            <i class="fas fa-plus"></i> Tambah UOM
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar UOM</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>UOM</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($satuanProduks as $index => $satuan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $satuan->UOM_Code }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $satuan->UOM_Auto }}"
                                    data-code="{{ $satuan->UOM_Code }}"
                                    data-amount="{{ $satuan->UOM_Amount }}"
                                    data-toggle="modal" 
                                    data-target="#editSatuanModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $satuan->UOM_Auto }}"
                                    data-code="{{ $satuan->UOM_Code }}"
                                    data-toggle="modal" 
                                    data-target="#deleteSatuanModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Add Modal -->
<div class="modal fade" id="addSatuanModal" tabindex="-1" aria-labelledby="addSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSatuanModalLabel">Tambah Satuan Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('satuanproduk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="UOM_Code">UOM</label>
                        <input type="text" class="form-control" id="UOM_Code" name="UOM_Code" maxlength="5" required>
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
<div class="modal fade" id="editSatuanModal" tabindex="-1" aria-labelledby="editSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSatuanModalLabel">Edit Satuan Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_code">Kode UOM</label>
                        <input type="text" class="form-control" id="edit_code" name="UOM_Code" maxlength="3" required>
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
<div class="modal fade" id="deleteSatuanModal" tabindex="-1" aria-labelledby="deleteSatuanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSatuanModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong id="delete_code"></strong>?</p>
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
            var url = "{{ route('satuanproduk.update', ':id') }}".replace(':id', id);
            $('#editForm').attr('action', url);
            $('#edit_code').val($(this).data('code'));
            $('#edit_amount').val($(this).data('amount'));
        });

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('satuanproduk.destroy', ':id') }}".replace(':id', id);
            $('#deleteForm').attr('action', url);
            $('#delete_code').text($(this).data('code'));
        });
    });
</script>
@endsection