@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Staf</h1>
    <p class="mb-4">Manajemen Data Staf untuk aplikasi.</p>

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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStaffModal">
            <i class="fas fa-plus"></i> Tambah Data Staf
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Staf</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Profil Staf</th>
                            <th width="25%">Informasi</th>
                            <th width="40%">Keterangan</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffs as $index => $staff)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="text-center">
                                    <img src="{{ $staff->profile_image_url }}" alt="Profil Staf" class="img-thumbnail" width="100">
                                    <h5 class="mt-2">{{ $staff->name }}</h5>
                                    <p class="text-muted">{{ $staff->jabatan }}</p>
                                </div>
                            </td>
                            <td>
                                <p><strong>Pendidikan:</strong></p>
                                <div class="border p-2 bg-light">
                                    {!! nl2br(e($staff->education)) !!}
                                </div>
                            </td>
                            <td>
                                <div class="border p-2 bg-light">
                                    {!! nl2br(e($staff->description)) !!}
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $staff->id }}"
                                    data-name="{{ $staff->name }}"
                                    data-jabatan="{{ $staff->jabatan }}"
                                    data-profile_image="{{ $staff->profile_image }}"
                                    data-description="{{ $staff->description }}"
                                    data-education="{{ $staff->education }}"
                                    data-status="{{ $staff->status }}"
                                    data-toggle="modal" 
                                    data-target="#editStaffModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $staff->id }}"
                                    data-name="{{ $staff->name }}"
                                    data-toggle="modal" 
                                    data-target="#deleteStaffModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data staf</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Tambah Data Staf</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('comprof.datastaf.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                            </div>
                            <div class="form-group">
                                <label for="profile_image">Foto Profil</label>
                                <input type="file" class="form-control-file" id="profile_image" name="profile_image" required>
                                <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="education">Pendidikan</label>
                                <textarea class="form-control" id="education" name="education" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Keterangan</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
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

<!-- Edit Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">Edit Data Staf</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_profile_image">Foto Profil</label>
                                <input type="file" class="form-control-file" id="edit_profile_image" name="profile_image">
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                <div id="currentImage" class="mt-2"></div>
                            </div>
                            <div class="form-group">
                                <label for="edit_status">Status</label>
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_education">Pendidikan</label>
                                <textarea class="form-control" id="edit_education" name="education" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Keterangan</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                            </div>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStaffModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data staf: <strong id="delete_name"></strong>?</p>
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
            var url = "{{ route('comprof.datastaf.update', ':id') }}".replace(':id', id);
            var imagePath = $(this).data('profile_image');
            var currentImageHtml = '';
            
            if (imagePath) {
                currentImageHtml = `<p>Gambar Saat Ini:</p>
                                  <img src="{{ asset('storage') }}/${imagePath}" class="img-thumbnail" width="100">`;
            } else {
                currentImageHtml = '<p>Tidak ada gambar</p>';
            }
            
            $('#editForm').attr('action', url);
            $('#edit_name').val($(this).data('name'));
            $('#edit_jabatan').val($(this).data('jabatan'));
            $('#edit_description').val($(this).data('description'));
            $('#edit_education').val($(this).data('education'));
            $('#edit_status').val($(this).data('status'));
            $('#currentImage').html(currentImageHtml);
        });

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = "{{ route('comprof.datastaf.destroy', ':id') }}".replace(':id', id);
            var name = $(this).data('name');
            
            $('#deleteForm').attr('action', url);
            $('#delete_name').text(name);
        });
    });
</script>
@endsection