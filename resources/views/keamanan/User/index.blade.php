@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Hak Akses</h1>
    <p class="mb-4">Atur Hak Akses User</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Pengguna {{ isset($memberToEdit) ? 'Edit' : 'Baru' }}</h6>
        </div>
        <div class="card-body">
            <form id="memberForm" action="{{ isset($memberToEdit) ? route('keamanan.member.update', $memberToEdit->Mem_Auto) : route('keamanan.member.store') }}" method="POST">
                @csrf
                @if(isset($memberToEdit))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mem_ID">Kode Karyawan</label>
                            <select name="Mem_ID" id="Mem_ID" class="form-control select2-employee" {{ isset($memberToEdit) ? 'disabled' : 'required' }}>
                                @if(isset($memberToEdit))
                                    <option value="{{ $memberToEdit->Mem_ID }}" selected>
                                        {{ $memberToEdit->Mem_UserName }} ({{ $memberToEdit->Mem_ID }})
                                    </option>
                                @else
                                    <option value="">-- Pilih Karyawan --</option>
                                @endif
                            </select>
                            @if(isset($memberToEdit))
                                <input type="hidden" name="Mem_ID" value="{{ $memberToEdit->Mem_ID }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mem_UserName">Nama Pengguna</label>
                            <input type="text" name="Mem_UserName" id="Mem_UserName" class="form-control bg-light" 
                                value="{{ old('Mem_UserName', $memberToEdit->Mem_UserName ?? '') }}" readonly required>
                        </div>
                    </div>
                </div>

                                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mem_password" class="font-weight-bold">Password</label>
                            <div class="input-group">
                                <input type="password" name="mem_password" id="mem_password" class="form-control"
                                    placeholder="{{ isset($memberToEdit) ? 'Kosongkan jika tidak diubah' : '' }}"
                                    {{ isset($memberToEdit) ? '' : 'required' }}>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Minimal 8 karakter</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password" class="font-weight-bold">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    {{ isset($memberToEdit) ? '' : 'required' }}>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Mem_ActiveYN">Status</label>
                            <select name="Mem_ActiveYN" id="Mem_ActiveYN" class="form-control">
                                <option value="Y" {{ old('Mem_ActiveYN', $memberToEdit->Mem_ActiveYN ?? 'Y') == 'Y' ? 'selected' : '' }}>Aktif</option>
                                <option value="N" {{ old('Mem_ActiveYN', $memberToEdit->Mem_ActiveYN ?? '') == 'N' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role_id">Role Utama</label>
                            <select name="role_id" id="role_id" class="form-control" required onchange="toggleAccessSection(this.value)">
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $memberToEdit->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="userAccessSection" class="mt-4 d-none">
                    <h5 class="font-weight-bold mb-3">Hak Akses Per Role</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Role</th>
                                    <th class="text-center">Tambah</th>
                                    <th class="text-center">Ubah</th>
                                    <th class="text-center">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="selectedRoleNameDisplay"></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="akses_role[0][tambah]" id="akses_role_tambah" value="1" class="form-check-input">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="akses_role[0][ubah]" id="akses_role_ubah" value="1" class="form-check-input">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="akses_role[0][hapus]" id="akses_role_hapus" value="1" class="form-check-input">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-4">
                    {{-- Tombol Simpan/Update User --}}
                    <!-- @can('tambah', 'keamanan.member') {{-- Cek Gate 'tambah' untuk membuat user baru --}} -->
                    @unless(isset($memberToEdit)) {{-- Hanya tampil jika mode "Buat Baru" --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pengguna Baru
                    </button>
                    @endunless
                    <!-- @endcan -->

                    <!-- @can('ubah', 'keamanan.member') {{-- Cek Gate 'ubah' untuk memperbarui user --}} -->
                    @if(isset($memberToEdit)) {{-- Hanya tampil jika mode "Edit" --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Pengguna
                    </button>
                    @endif
                    <!-- @endcan -->

                    @if(isset($memberToEdit)) {{-- Tombol Buat Baru/Batal di mode edit --}}
                    <a href="{{ route('keamanan.member.index') }}" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-plus"></i> Buat Baru
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->Mem_ID }}</td>
                            <td>{{ $member->Mem_UserName }}</td>
                            <td>{{ $member->role->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $member->Mem_ActiveYN == 'Y' ? 'success' : 'danger' }}">
                                    {{ $member->Mem_ActiveYN == 'Y' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- Tombol Edit User --}}
                                @can('ubah', 'keamanan.member') {{-- Cek Gate 'ubah' untuk user --}}
                                <a href="{{ route('keamanan.member.edit', $member->Mem_Auto) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                {{-- Tombol Delete User --}}
                                @can('hapus', 'keamanan.member') {{-- Cek Gate 'hapus' untuk user --}}
                                <form action="{{ route('keamanan.member.destroy', $member->Mem_Auto) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable();

        // Toggle password visibility
        $('.toggle-password').click(function() {
            const input = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Handle notifications
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 5000
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: `
                    <strong>Validasi gagal:</strong>
                    <ul class="text-left mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                showConfirmButton: true
            });
        @endif

        // Initialize Select2
        $('#Mem_ID').select2({
            placeholder: 'Pilih Karyawan',
            allowClear: true,
            ajax: {
                url: '{{ route('keamanan.member.searchEmployees') }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        }).on('select2:select', function (e) {
            const data = e.params.data;
            $('#Mem_UserName').val(data.text.split(' (')[0]);
        });

        // Initialize role access section
        if ($('#role_id').val()) {
            toggleAccessSection($('#role_id').val());
        }

        // Delete confirmation
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Hapus Pengguna?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    function toggleAccessSection(roleId) {
        const section = $('#userAccessSection');
        const roleName = $('#selectedRoleNameDisplay');
        
        if (roleId) {
            const selectedRole = @json($roles->keyBy('id'));
            roleName.text(selectedRole[roleId]?.name || '');
            
            // Update checkbox names with role ID
            $('#akses_role_tambah').attr('name', `akses_role[${roleId}][tambah]`);
            $('#akses_role_ubah').attr('name', `akses_role[${roleId}][ubah]`);
            $('#akses_role_hapus').attr('name', `akses_role[${roleId}][hapus]`);
            
            // Set checkbox states based on existing permissions
            const permissions = @json($simplifiedAccesses);
            if (permissions[roleId]) {
                $('#akses_role_tambah').prop('checked', permissions[roleId].tambah == '1');
                $('#akses_role_ubah').prop('checked', permissions[roleId].ubah == '1');
                $('#akses_role_hapus').prop('checked', permissions[roleId].hapus == '1');
            } else {
                $('input[type="checkbox"]').prop('checked', false);
            }
            
            section.removeClass('d-none');
        } else {
            section.addClass('d-none');
        }
    }
</script>
@endpush