@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Kode Akuntansi</h1>
<br>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <!-- Add New Code Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCodeModal">
            <i class="fas fa-plus"></i> Tambah Kode
        </button>
    </div>

    <!-- Accounting Code Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kode Akuntansi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Akun</th>
                            <th width="20%">Perkiraan</th>
                            <th width="15%">Klasifikasi</th>
                            <th width="15%">Sub Klasifikasi</th>
                            <th width="10%">Cash / Bank</th>
                            <th width="5%">D / K</th>
                            <th width="10%">Pengguna</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kodes as $index => $kode)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kode->cls_kiraid }}</td>
                            <td>{{ $kode->cls_ina }}</td>
                            <td>{{ $kode->accClass->cls_ina }}</td>
                            <td>{{ $kode->accSubclass->cls_ina }}</td>
                            <td>{{ $kode->status }}</td>
                            <td>{{ $kode->d_k }}</td>
                            <td>{{ Auth::user()->name ?? 'System' }}</td>
                            <td>{{ \Carbon\Carbon::parse($kode->tanggal)->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $kode->id }}"
                                    data-kiraid="{{ $kode->cls_kiraid }}"
                                    data-ina="{{ $kode->cls_ina }}"
                                    data-status="{{ $kode->status }}"
                                    data-dk="{{ $kode->d_k }}"
                                    data-toggle="modal" data-target="#editCodeModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="{{ $kode->id }}"
                                    data-kiraid="{{ $kode->cls_kiraid }}"
                                    data-toggle="modal" data-target="#deleteCodeModal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($kodes) > 0)
            <!-- Tampilkan tabel -->
            @else
                <div class="alert alert-info">Tidak ada kode akuntansi tersedia.</div>
            @endif
        </div>
    </div>
</div>

<!-- Add Code Modal -->
<div class="modal fade" id="addCodeModal" tabindex="-1" role="dialog" aria-labelledby="addCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCodeModalLabel">Tambah Kode Akuntansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kodeakunting.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="cls_id" class="col-sm-3 col-form-label">Klasifikasi</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="cls_id" name="cls_id" required>
                                <option value="">-- Pilih Klasifikasi --</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->cls_id }}">{{ $class->cls_ina }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cls_subid" class="col-sm-3 col-form-label">Sub Klasifikasi</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="cls_subid" name="cls_subid" required>
                                <option value="">-- Pilih Sub Klasifikasi --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cls_ina" class="col-sm-3 col-form-label">Perkiraan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="cls_ina" name="cls_ina" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
                                <option value="umum">Umum</option>
                                <option value="cash/bank">Cash/Bank</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="d_k" class="col-sm-3 col-form-label">Debet/Kredit</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="d_k" name="d_k" required>
                                <option value="debet">Debet</option>
                                <option value="kredit">Kredit</option>
                            </select>
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

<!-- Edit Code Modal -->
<div class="modal fade" id="editCodeModal" tabindex="-1" role="dialog" aria-labelledby="editCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCodeModalLabel">Edit Kode Akuntansi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="{{ isset($kode) && $kode ? route('kodeakunting.update', ['id' => $kode->id]) : '#' }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group row">
                        <label for="edit_cls_kiraid" class="col-sm-3 col-form-label">Kode Akun</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_cls_kiraid" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_cls_ina" class="col-sm-3 col-form-label">Perkiraan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_cls_ina" name="cls_ina" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="umum">Umum</option>
                                <option value="cash/bank">Cash/Bank</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_d_k" class="col-sm-3 col-form-label">Debet/Kredit</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_d_k" name="d_k" required>
                                <option value="debet">Debet</option>
                                <option value="kredit">Kredit</option>
                            </select>
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

<!-- Delete Code Modal -->
<div class="modal fade" id="deleteCodeModal" tabindex="-1" role="dialog" aria-labelledby="deleteCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCodeModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kode akuntansi <strong id="delete_cls_kiraid"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="{{ isset($kode) && $kode ? route('kodeakunting.destroy', ['id' => $kode->id]) : '#' }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    const subclasses = @json($subclasses);

    document.addEventListener('DOMContentLoaded', function() {
        const clsSelect = document.getElementById('cls_id');
        const subclsSelect = document.getElementById('cls_subid');

        clsSelect.addEventListener('change', function() {
            const selectedClsId = this.value;

            // Clear sub klasifikasi dulu
            subclsSelect.innerHTML = '<option value="">-- Pilih Sub Klasifikasi --</option>';

            // Filter subclasses yang punya cls_id sesuai
            const filteredSubclasses = subclasses.filter(sub => sub.cls_id == selectedClsId);

            // Masukkan option baru
            filteredSubclasses.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.cls_subid;
                option.text = sub.cls_ina;
                subclsSelect.appendChild(option);
            });
        });
    });
</script>
@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable();

        // Handle class change to populate subclasses
        $('#cls_id').change(function() {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    url: '{{ route("kodeakunting.getSubclasses", "") }}/' + classId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#cls_subid').empty();
                        $('#cls_subid').append('<option value="">-- Pilih Sub Klasifikasi --</option>');
                        $.each(data, function(key, value) {
                            $('#cls_subid').append('<option value="' + value.cls_subid + '">' + value.cls_subid + ' - ' + value.cls_ina + '</option>');
                        });
                    }
                });
            } else {
                $('#cls_subid').empty();
                $('#cls_subid').append('<option value="">-- Pilih Sub Klasifikasi --</option>');
            }
        });

        // Handle edit button click
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            var kiraid = $(this).data('kiraid');
            var ina = $(this).data('ina');
            var status = $(this).data('status');
            var dk = $(this).data('dk');

            $('#edit_cls_kiraid').val(kiraid);
            $('#edit_cls_ina').val(ina);
            $('#edit_status').val(status);
            $('#edit_d_k').val(dk);

            // Dynamically update the form action URL for the PUT request
            var updateUrl = '{{ route("kodeakunting.update", ":id") }}';
            updateUrl = updateUrl.replace(':id', id);
            $('#editForm').attr('action', updateUrl);
        });

        // Handle delete button click
        $('.delete-btn').click(function() {
        var id = $(this).data('id');
        var kiraid = $(this).data('kiraid');

        $('#delete_cls_kiraid').text(kiraid);

        // Dynamically update the form action URL for the DELETE request
        var deleteUrl = '{{ route("kodeakunting.destroy", ":id") }}';
        deleteUrl = deleteUrl.replace(':id', id);
        $('#deleteForm').attr('action', deleteUrl);
    });
    });
    </script>

@endsection
