@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Setting Menu</h1>
    <p class="mb-4">Manajemen setting menu untuk aplikasi.</p>

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

    <!-- Add New Menu Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMenuModal">
            <i class="fas fa-plus"></i> Tambah Menu
        </button>
    </div>

    <!-- Menu Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>  
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Menu</th>
                            <th width="10%">Urut</th>
                            <th width="15%">Status</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $index => $menu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($menu->parent)
                                    <i class="fas fa-level-up-alt fa-rotate-90 mr-2"></i>
                                @endif
                                {{ $menu->nama_menu }}
                                @if($menu->route)
                                    <br><small class="text-muted">{{ $menu->route }}</small>
                                @endif
                            </td>
                            <td>{{ $menu->urutan }}</td>
                            <td>
                                @if($menu->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $menu->id }}"
                                    data-nama_menu="{{ $menu->nama_menu }}"
                                    data-slug="{{ $menu->slug }}"
                                    data-route="{{ $menu->route }}"
                                    data-urutan="{{ $menu->urutan }}"
                                    data-parent_id="{{ $menu->parent_id }}"
                                    data-status="{{ $menu->status }}"
                                    data-toggle="modal" data-target="#editMenuModal">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $menu->id }}"
                                    data-nama_menu="{{ $menu->nama_menu }}"
                                    data-toggle="modal" data-target="#deleteMenuModal">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data menu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('comprof.settingmenu.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu *</label>
                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug *</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                        <small class="form-text text-muted">URL identifier untuk menu (harus unik)</small>
                    </div>
                    <div class="form-group">
                        <label for="route">Route</label>
                        <input type="text" class="form-control" id="route" name="route" placeholder="contoh: dashboard.index">
                    </div>
                    <div class="form-group">
                        <label for="urutan">Urutan *</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" required min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent Menu</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">-- Menu Utama --</option>
                            @foreach($menus->whereNull('parent_id') as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
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

<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_menu">Nama Menu *</label>
                        <input type="text" class="form-control" id="edit_nama_menu" name="nama_menu" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_slug">Slug *</label>
                        <input type="text" class="form-control" id="edit_slug" name="slug" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_route">Route</label>
                        <input type="text" class="form-control" id="edit_route" name="route">
                    </div>
                    <div class="form-group">
                        <label for="edit_urutan">Urutan *</label>
                        <input type="number" class="form-control" id="edit_urutan" name="urutan" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="edit_parent_id">Parent Menu</label>
                        <select class="form-control" id="edit_parent_id" name="parent_id">
                            <option value="">-- Menu Utama --</option>
                            @foreach($menus->whereNull('parent_id') as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status *</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
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

<!-- Delete Menu Modal -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus menu <strong id="delete_nama_menu"></strong>?</p>
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
            var url = "{{ route('comprof.settingmenu.update', ':id') }}".replace(':id', id);
            
            $('#editForm').attr('action', url);
            $('#edit_nama_menu').val($(this).data('nama_menu'));
            $('#edit_slug').val($(this).data('slug'));
            $('#edit_route').val($(this).data('route'));
            $('#edit_urutan').val($(this).data('urutan'));
            $('#edit_parent_id').val($(this).data('parent_id'));
            $('#edit_status').val($(this).data('status'));
        });

        // Handle delete button click
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('comprof.settingmenu.destroy', ':id') }}".replace(':id', id);
            var nama = $(this).data('nama_menu');
            
            $('#deleteForm').attr('action', url);
            $('#delete_nama_menu').text(nama);
        });

        // Auto generate slug from nama_menu
        $('#nama_menu').on('keyup', function() {
            var nama = $(this).val();
            var slug = nama.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
            $('#slug').val(slug);
        });
    });
</script>
@endsection