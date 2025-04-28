@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Role</h1>
    <p class="mb-4">Manajemen role untuk kontrol akses pengguna.</p>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Add New Role Button -->
    <div class="mb-3">
        <a href="{{ route('keamanan.role.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle"></i> Tambah Role
        </a>
    </div>

    <!-- Role Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Role</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Role</th>
                            <th>Pengguna</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $index => $role)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->users_count ?? 0 }}</td>
                            <td>{{ $role->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('keamanan.role.edit', $role->id) }}" class="btn btn-warning btn-sm btn-icon">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('keamanan.role.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-icon" onclick="return confirm('Yakin ingin menghapus role ini?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada role.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
