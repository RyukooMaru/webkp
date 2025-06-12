@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Data Divisi</h1>
    <p class="mb-4">Manajemen Data Divisi & Sub-Divisi untuk aplikasi.</p>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="mb-3">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addDivisiModal">
            <span class="icon text-white-100">
                <i class="fas fa-plus mt-1"></i>
            </span>
            <span class="text">Tambah Divisi</span>
        </a>
    </div>

    <!-- Divisi Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Divisi</h6>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseDivisi" role="button" aria-expanded="false" aria-controls="collapseDivisi">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapseDivisi">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Divisi</th>
                                <th>Nama Divisi</th>
                                <th>NIK</th>
                                <th>Shift (Y/N)</th>
                                <th>Biaya</th>
                                <th>Entry ID</th>
                                <th>Entry Date</th>
                                <th>User ID</th>
                                <th>Last Update</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode Divisi</th>
                                <th>Nama Divisi</th>
                                <th>NIK</th>
                                <th>Shift (Y/N)</th>
                                <th>Biaya</th>
                                <th>Entry ID</th>
                                <th>Entry Date</th>
                                <th>User ID</th>
                                <th>Last Update</th>
                                <th>Tindakan</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($Divisis as $index => $Divisi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $Divisi->Div_Code }}</td>
                                <td>{{ $Divisi->Div_Name }}</td>
                                <td>{{ $Divisi->DIV_NIK }}</td>
                                <td>{{ $Divisi->DIV_SHIFTYN }}</td>
                                <td>{{ $Divisi->DIV_BIAYA }}</td>
                                <td>{{ $Divisi->Div_EntryID }}</td>
                                <td>{{ \Carbon\Carbon::parse($Divisi->Div_Entrydate)->format('d-m-Y H:i') }}</td>
                                <td>{{ $Divisi->Div_UserID }}</td>
                                <td>{{ $Divisi->Div_LastUpdate }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-btn edit-divisi-btn"
                                        data-divid="{{ $Divisi->div_auto }}"
                                        data-divcode="{{ $Divisi->Div_Code }}"
                                        data-divname="{{ $Divisi->Div_Name }}"
                                        data-divnik="{{ $Divisi->DIV_NIK }}"
                                        data-divshiftyn="{{ $Divisi->DIV_SHIFTYN }}"
                                        data-divbiaya="{{ $Divisi->DIV_BIAYA }}"
                                        data-divisiurl="{{ route('divisi.update', $Divisi) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-btn delete-divbtn" 
                                    data-deldivisiurl="{{ route('divisi.destroy', $Divisi) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($Divisis) > 0)
                <!-- Tampilkan tabel -->
                @else
                    <div class="alert alert-info">Tidak ada Data Divisi tersedia.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sub-Divisi Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Sub-Divisi</h6>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseSubDivisi" role="button" aria-expanded="false" aria-controls="collapseSubDivisi">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapseSubDivisi">
            <div class="card-body">
                <a href="#" class="btn btn-primary btn-icon-split mb-4" data-toggle="modal" data-target="#addSubDivisiModal">
                    <span class="icon text-white-100">
                        <i class="fas fa-plus mt-1"></i>
                    </span>
                    <span class="text">Tambah Sub-Divisi</span>
                </a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Divisi</th>
                                <th>Code Sub-Divisi</th>
                                <th>Nama Sub-Divisi</th>
                                <th>NIK</th>
                                <th>Entry ID</th>
                                <th>Entry Date</th>
                                <th>User ID</th>
                                <th>Last Update</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Divisi</th>
                                <th>Code Sub-Divisi</th>
                                <th>Nama Sub-Divisi</th>
                                <th>NIK</th>
                                <th>Entry ID</th>
                                <th>Entry Date</th>
                                <th>User ID</th>
                                <th>Last Update</th>
                                <th>Tindakan</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($SubDivisis as $index => $SubDivisi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $SubDivisi->div_divcode }}</td>
                                <td>{{ $SubDivisi->Div_Code }}</td>
                                <td>{{ $SubDivisi->Div_Name }}</td>
                                <td>{{ $SubDivisi->DIV_NIK }}</td>
                                <td>{{ $SubDivisi->Div_EntryID }}</td>
                                <td>{{ \Carbon\Carbon::parse($SubDivisi->Div_Entrydate)->format('d-m-Y H:i') }}</td>
                                <td>{{ $SubDivisi->Div_UserID }}</td>
                                <td>{{ $SubDivisi->Div_LastUpdate }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning edit-btn edit-subdivisi-btn"
                                        data-subid="{{ $SubDivisi->div_auto }}"
                                        data-subdivid="{{ $SubDivisi->div_divcode }}"
                                        data-subdivcode="{{ $SubDivisi->Div_Code }}"
                                        data-subdivname="{{ $SubDivisi->Div_Name }}"
                                        data-subdivnik="{{ $SubDivisi->DIV_NIK }}"
                                        data-subdivisiurl="{{ route('subdivisi.update', $SubDivisi) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-subdivbtn" 
                                    data-delsubdivisiurl="{{ route('subdivisi.destroy', $SubDivisi) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($SubDivisis) > 0)
                <!-- Tampilkan tabel -->
                @else
                    <div class="alert alert-info">Tidak ada Data Sub-Divisi tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Divisi -->
 <div class="modal fade" id="addDivisiModal" tabindex="-1" role="dialog" aria-labelledby="addDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDivisiModalLabel"> Tambah Data Divisi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('divisi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Code" class="col-sm-3 col-form-label">Kode Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="Div_Code" name="Div_Code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Name" class="col-sm-3 col-form-label">Nama Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="Div_Name" name="Div_Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="DIV_NIK" class="col-sm-3 col-form-label">NIK</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="DIV_NIK" name="DIV_NIK" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="DIV_SHIFTYN" class="col-sm-3 col-form-label">Shift (Y/T)</label>
                                <div class="col-sm-12">
                                    <select class="form-control bg-light small" id="DIV_SHIFTYN" name="DIV_SHIFTYN" required>
                                        <option selected value="T">Tidak</option>
                                        <option value="Y">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="DIV_BIAYA" class="col-sm-3 col-form-label">Biaya</label>
                                <div class="col-sm-12">
                                    <select class="form-control bg-light small" id="DIV_BIAYA" name="DIV_BIAYA">
                                        <option selected value="" >Pilih</option>
                                        <option value="T">Tidak</option>
                                        <option value="Y">Ya</option>
                                    </select>
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
<div class="modal fade" id="editDivisiModal" tabindex="-1" aria-labelledby="editDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDivisiModalLabel"> Edit Data Divisi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action=""  id="editDivisiForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Code" class="col-sm-3 col-form-label">Kode Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editDivCode" name="Div_Code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Name" class="col-sm-3 col-form-label">Nama Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editDivName" name="Div_Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="DIV_NIK" class="col-sm-3 col-form-label">NIK</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editNIK" name="DIV_NIK" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="DIV_SHIFTYN" class="col-sm-3 col-form-label">Shift (Y/T)</label>
                                <div class="col-sm-12">
                                    <select class="form-control bg-light small" id="editShiftYN" name="DIV_SHIFTYN" required>
                                        <option value="T">Tidak</option>
                                        <option value="Y">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="DIV_BIAYA" class="col-sm-3 col-form-label">Biaya</label>
                                <div class="col-sm-12">
                                    <select class="form-control bg-light small" id="editBiaya" name="DIV_BIAYA">
                                        <option value="T">Tidak</option>
                                        <option value="Y">Ya</option>
                                    </select>
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
<div class="modal fade" id="confirmDivisiDeleteModal" tabindex="-1" aria-labelledby="confirmDivisiDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDivisiDeleteModalLabel">Konfirmasi Penghapusan Data Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteDivisiForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" >Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ////////////////////////////////////////////////////////////////////////// -->

<!-- Modal Tambah Data Sub-Divisi -->
<div class="modal fade" id="addSubDivisiModal" tabindex="-1" role="dialog" aria-labelledby="addSubDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubDivisiModalLabel"> Tambah Data Sub-Divisi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subdivisi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="div_divcode" class="col-sm-3 col-form-label">ID Divisi</label>
                                <div class="col-sm-12">
                                    <select class="form-control bg-light small" id="div_divcode" name="div_divcode" required>
                                        <option selected value="" >Pilih</option>
                                        @foreach($Divisis as $Divisi)
                                            <option value="{{ $Divisi->div_auto }}">{{ $Divisi->Div_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Code" class="col-sm-3 col-form-label">Kode Sub-Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="Div_Code" name="Div_Code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Name" class="col-sm-3 col-form-label">Nama Sub-Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="Div_Name" name="Div_Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="DIV_NIK" class="col-sm-3 col-form-label">NIK</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="DIV_NIK" name="DIV_NIK">
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

<!-- Modal Edit Sub-Divisi -->
<div class="modal fade" id="editSubDivisiModal" tabindex="-1" aria-labelledby="editSubDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSubDivisiModalLabel"> Edit Data Sub-Divisi </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action=""  id="editSubDivisiForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="div_divcode" class="col-sm-3 col-form-label">ID Divisi</label>
                                <div class="col-sm-12">
                                    <select class="form-control bg-light small" id="editDividCode" name="div_divcode" required>
                                        <option selected value="" >Pilih</option>
                                        @foreach($Divisis as $Divisi)
                                            <option value="{{ $Divisi->div_auto }}">{{ $Divisi->Div_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Code" class="col-sm-3 col-form-label">Kode Sub-Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editSubDivCode" name="Div_Code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Div_Name" class="col-sm-3 col-form-label">Nama Sub-Divisi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editSubDivName" name="Div_Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="DIV_NIK" class="col-sm-3 col-form-label">NIK</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control bg-light small" id="editSubDivNIK" name="DIV_NIK">
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

<!-- Modal Konfirmasi Sub-Divisi Hapus -->
<div class="modal fade" id="confirmSubDivisiDeleteModal" tabindex="-1" aria-labelledby="confirmSubDivisiDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmSubDivisiDeleteModalLabel">Konfirmasi Penghapusan Data Sub-Divisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteSubDivisiForm">
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
        const editDivButtons = document.querySelectorAll('.edit-divisi-btn');
        const editDivForm = document.getElementById('editDivisiForm');
        const editDivModal = new bootstrap.Modal(document.getElementById('editDivisiModal'));

        editDivButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil URL tujuan update dari data-url di tombol edit
                const url = this.getAttribute('data-divisiurl');
                
                // Ambil data dari atribut data di tombol
                const divId = this.getAttribute('data-divid');
                const divCode = this.getAttribute('data-divcode');
                const divName = this.getAttribute('data-divname');
                const divNik = this.getAttribute('data-divnik');
                const divShiftYN = this.getAttribute('data-divshiftyn');
                const divBiaya = this.getAttribute('data-divbiaya');

                // Set nilai form edit
                document.getElementById('editDivCode').value = divCode;
                document.getElementById('editDivName').value = divName;
                document.getElementById('editNIK').value = divNik;
                document.getElementById('editShiftYN').value = divShiftYN;
                document.getElementById('editBiaya').value = divBiaya;

                // Ubah action form ke URL update
                editDivForm.setAttribute('action', url);

                // Tampilkan modal edit
                editDivModal.show();
            });
        });

        // Edit Sub-Divisi
        
        const editSubDivButtons = document.querySelectorAll('.edit-subdivisi-btn');
        const editSubDivForm = document.getElementById('editSubDivisiForm');
        const editSubDivModal = new bootstrap.Modal(document.getElementById('editSubDivisiModal'));


        editSubDivButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil URL tujuan update dari data-url di tombol edit
                const url = this.getAttribute('data-subdivisiurl');
                
                // Ambil data dari atribut data di tombol
                const subId = this.getAttribute('data-subid');
                const subdivId = this.getAttribute('data-subdivid');
                const subdivCode = this.getAttribute('data-subdivcode');
                const subdivName = this.getAttribute('data-subdivname');
                const subdivNik = this.getAttribute('data-subdivnik');

                // Set nilai form edit
                document.getElementById('editDividCode').value = subdivId;
                document.getElementById('editSubDivCode').value = subdivCode;
                document.getElementById('editSubDivName').value = subdivName;
                document.getElementById('editSubDivNIK').value = subdivNik;

                // Ubah action form ke URL update
                editSubDivForm.setAttribute('action', url);
                // Tampilkan modal edit
                editSubDivModal.show();
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const deleteDivButtons = document.querySelectorAll('.delete-divbtn');
        const deleteDivForm = document.getElementById('deleteDivisiForm');
        const modalDiv = new bootstrap.Modal(document.getElementById('confirmDivisiDeleteModal'));

        deleteDivButtons.forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-deldivisiurl');
                deleteDivForm.setAttribute('action', url);
                modalDiv.show();
            });
        });

        const deleteSubDivButtons = document.querySelectorAll('.delete-subdivbtn');
        const deleteSubDivForm = document.getElementById('deleteSubDivisiForm');
        const modalSubDiv = new bootstrap.Modal(document.getElementById('confirmSubDivisiDeleteModal'));

        deleteSubDivButtons.forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-delsubdivisiurl');
                deleteSubDivForm.setAttribute('action', url);
                modalSubDiv.show();
            });
        });
    });

</script>
