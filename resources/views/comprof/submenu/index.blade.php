@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Setting Sub Menu</h1>
    <p class="mb-4">Manajemen setting sub menu untuk aplikasi.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Add New Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubMenuModal">
            <i class="fas fa-plus"></i> Tambah Sub Menu
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sub Menu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Menu</th>
                            <th width="20%">Sub Menu</th>
                            <th width="10%">Urut</th>
                            <th width="20%">Tautan</th>
                            <th width="10%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submenus as $index => $submenu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $submenu->menu->nama_menu ?? '-' }}</td>
                            <td>{{ $submenu->nama_submenu }}</td>
                            <td>{{ $submenu->urut }}</td>
                            <td>{{ $submenu->tautan }}</td>
                            <td>
                                @if($submenu->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $submenu->id }}"
                                    data-menu_id="{{ $submenu->menu_id }}"
                                    data-nama_submenu="{{ $submenu->nama_submenu }}"
                                    data-urut="{{ $submenu->urut }}"
                                    data-tautan="{{ $submenu->tautan }}"
                                    data-status="{{ $submenu->status }}"
                                    data-toggle="modal" 
                                    data-target="#editSubMenuModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $submenu->id }}"
                                    data-nama_submenu="{{ $submenu->nama_submenu }}"
                                    data-toggle="modal" 
                                    data-target="#deleteSubMenuModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addSubMenuModal" tabindex="-1" aria-labelledby="addSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubMenuModalLabel">Tambah Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('comprof.settingsubmenu.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="menu_id">Menu</label>
                        <select class="form-control" id="menu_id" name="menu_id" required>
                            <option value="">Pilih Menu</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_submenu">Nama Sub Menu</label>
                        <input type="text" class="form-control" id="nama_submenu" name="nama_submenu" required>
                    </div>
                    <div class="form-group">
                        <label for="urut">Urutan</label>
                        <input type="number" class="form-control" id="urut" name="urut" required>
                    </div>
                    <div class="form-group">
                        <label for="tautan">Tautan</label>
                        <input type="text" class="form-control" id="tautan" name="tautan" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
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
<div class="modal fade" id="editSubMenuModal" tabindex="-1" aria-labelledby="editSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubMenuModalLabel">Edit Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_menu_id">Menu</label>
                        <select class="form-control" id="edit_menu_id" name="menu_id" required>
                            <option value="">Pilih Menu</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_submenu">Nama Sub Menu</label>
                        <input type="text" class="form-control" id="edit_nama_submenu" name="nama_submenu" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_urut">Urutan</label>
                        <input type="number" class="form-control" id="edit_urut" name="urut" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tautan">Tautan</label>
                        <input type="text" class="form-control" id="edit_tautan" name="tautan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
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
<div class="modal fade" id="deleteSubMenuModal" tabindex="-1" aria-labelledby="deleteSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSubMenuModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong id="delete_nama_submenu"></strong>?</p>
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
            var url = "{{ route('comprof.settingsubmenu.update', ':id') }}".replace(':id', id);
            
            $('#editForm').attr('action', url);
            $('#edit_menu_id').val($(this).data('menu_id'));
            $('#edit_nama_submenu').val($(this).data('nama_submenu'));
            $('#edit_urut').val($(this).data('urut'));
            $('#edit_tautan').val($(this).data('tautan'));
            $('#edit_status').val($(this).data('status'));
        });

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('comprof.settingsubmenu.destroy', ':id') }}".replace(':id', id);
            var nama = $(this).data('nama_submenu');
            
            $('#deleteForm').attr('action', url);
            $('#delete_nama_submenu').text(nama);
        });
    });
</script>
@endsection