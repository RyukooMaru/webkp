@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Supplier</h1>
    <p class="mb-4">Manajemen Daftar Supplier untuk aplikasi.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Add New Supplier Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModal">
            <i class="fas fa-plus"></i> Tambah Supplier
        </button>
    </div>

    <!-- Supplier Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Supplier</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Kode</th>
                            <th width="20%">Supplier</th>
                            <th width="15%">Alamat</th>
                            <th width="15%">Contact Person</th>
                            <th width="10%">Telp</th>
                            <th width="10%">Email</th>
                            <th width="10%">Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $supplier->kode_supplier }}</td>
                            <td>{{ $supplier->nama_supplier }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td>{{ $supplier->contact_person }}</td>
                            <td>{{ $supplier->telp }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->tanggal->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $supplier->id }}"
                                    data-kode="{{ $supplier->kode_supplier }}"
                                    data-nama="{{ $supplier->nama_supplier }}"
                                    data-alamat="{{ $supplier->alamat }}"
                                    data-contact="{{ $supplier->contact_person }}"
                                    data-telp="{{ $supplier->telp }}"
                                    data-email="{{ $supplier->email }}"
                                    data-tanggal="{{ $supplier->tanggal->format('Y-m-d') }}"
                                    data-toggle="modal" data-target="#editSupplierModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $supplier->id }}"
                                    data-nama="{{ $supplier->nama_supplier }}"
                                    data-toggle="modal" data-target="#deleteSupplierModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data supplier</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Tambah Supplier Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_supplier" class="col-sm-3 col-form-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact_person" class="col-sm-3 col-form-label">Contact Person</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telp" class="col-sm-3 col-form-label">Telp</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="telp" name="telp" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}">
                        </div>
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

<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">Edit Data Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="edit_kode" class="col-sm-3 col-form-label">Kode Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_kode" name="kode_supplier" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_nama" class="col-sm-3 col-form-label">Nama Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_nama" name="nama_supplier" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_contact" class="col-sm-3 col-form-label">Contact Person</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_contact" name="contact_person" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_telp" class="col-sm-3 col-form-label">Telp</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_telp" name="telp" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="edit_tanggal" name="tanggal">
                        </div>
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

<!-- Delete Supplier Modal -->
<div class="modal fade" id="deleteSupplierModal" tabindex="-1" role="dialog" aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSupplierModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus supplier <strong id="delete_nama"></strong>?</p>
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
        // Initialize DataTable
        $('#dataTable').DataTable();

        // Handle edit button click
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('supplier.update', ':id') }}".replace(':id', id);
            
            $('#editForm').attr('action', url);
            $('#edit_kode').val($(this).data('kode'));
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_contact').val($(this).data('contact'));
            $('#edit_telp').val($(this).data('telp'));
            $('#edit_email').val($(this).data('email'));
            $('#edit_tanggal').val($(this).data('tanggal'));
        });

        // Handle delete button click
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('supplier.destroy', ':id') }}".replace(':id', id);
            var nama = $(this).data('nama');
            
            $('#deleteForm').attr('action', url);
            $('#delete_nama').text(nama);
        });
    });
</script>
@endsection