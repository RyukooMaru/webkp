@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Data Posisi</h1>
    <p class="mb-4">Manajemen Data Posisi untuk aplikasi.</p>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="mb-3">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addPosisiModal">
            <span class="icon text-white-100">
                <i class="fas fa-plus mt-1"></i>
            </span>
            <span class="text">Tambah Posisi</span>
        </a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Posisi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Posisi</th>
                            <th>Nama Posisi</th>
                            <th>User ID</th>
                            <th>Last Update</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kode Posisi</th>
                            <th>Nama Posisi</th>
                            <th>User ID</th>
                            <th>Last Update</th>
                            <th>Tindakan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($Posisis as $index => $Posisi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $Posisi->Pos_Code }}</td>
                            <td>{{ $Posisi->Pos_Name }}</td>
                            <td>{{ $Posisi->Pos_UserID }}</td>
                            <td>{{ $Posisi->Pos_LastUpdate }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning edit-btn edit-posisi-btn"
                                    data-posid="{{ $Posisi->pos_auto }}"
                                    data-poscode="{{ $Posisi->Pos_Code }}"
                                    data-posname="{{ $Posisi->Pos_Name }}"
                                    data-posisiurl="{{ route('posisi.update', $Posisi) }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-btn delete-posbtn" 
                                data-delposisiurl="{{ route('posisi.destroy', $Posisi) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($Posisis) > 0)
            <!-- Tampilkan tabel -->
            @else
                <div class="alert alert-info">Tidak ada Data Posisi tersedia.</div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah Data Posisi -->
<div class="modal fade" id="addPosisiModal" tabindex="-1" role="dialog" aria-labelledby="addPosisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPosisiModalLabel"> Tambah Data Posisi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('posisi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Pos_Code" class="col-sm-3 col-form-label">Kode Posisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="Pos_Code" name="Pos_Code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Pos_Name" class="col-sm-3 col-form-label">Nama Posisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="Pos_Name" name="Pos_Name" required>
                                </div>
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

<!-- Modal Edit Divisi -->
<div class="modal fade" id="editPosisiModal" tabindex="-1" aria-labelledby="editPosisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPosisiModalLabel"> Tambah Data Posisi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action=""  id="editPosisiForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Pos_Code" class="col-sm-3 col-form-label">Kode Posisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editPosCode" name="Pos_Code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Pos_Name" class="col-sm-3 col-form-label">Nama Posisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editPosName" name="Pos_Name" required>
                                </div>
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

<!-- Modal Konfirmasi Divisi Hapus -->
<div class="modal fade" id="confirmPosisiDeleteModal" tabindex="-1" aria-labelledby="confirmPosisiDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmPosisiDeleteModalLabel">Konfirmasi Penghapusan Data Posisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <form method="POST" id="deletePosisiForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" >Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Edit Divisi 
        const editPosButtons = document.querySelectorAll('.edit-posisi-btn');
        const editPosForm = document.getElementById('editPosisiForm');
        const editPosModal = new bootstrap.Modal(document.getElementById('editPosisiModal'));

        editPosButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil URL tujuan update dari data-url di tombol edit
                const url = this.getAttribute('data-posisiurl');
                
                // Ambil data dari atribut data di tombol
                const posId = this.getAttribute('data-posid');
                const posCode = this.getAttribute('data-poscode');
                const posName = this.getAttribute('data-posname');

                // Set nilai form edit
                document.getElementById('editPosCode').value = posCode;
                document.getElementById('editPosName').value = posName;

                // Ubah action form ke URL update
                editPosForm.setAttribute('action', url);

                // Tampilkan modal edit
                editPosModal.show();
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const deletePosButtons = document.querySelectorAll('.delete-posbtn');
        const deletePosForm = document.getElementById('deletePosisiForm');
        const modalPos = new bootstrap.Modal(document.getElementById('confirmPosisiDeleteModal'));

        deletePosButtons.forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-delposisiurl');
                deletePosForm.setAttribute('action', url);
                modalPos.show();
            });
        });
    });
</script>