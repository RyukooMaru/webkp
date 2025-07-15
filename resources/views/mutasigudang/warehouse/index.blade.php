    @extends('layouts.admin')

    @section('main-content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Daftar Gudang</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="mb-3">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#warehouseModal" onclick="openCreateForm()">
                <i class="fas fa-plus"></i> Tambah Gudang
            </button>
        </div>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Gudang</h6>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width=5% >No</th>
                            <th>Gudang</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Fax</th>
                            <th>Email</th>
                            <th>Web</th>
                            <th>Catatan 1</th>
                            <th>Catatan 2</th>
                            <th>Pengguna</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($warehouses as $index => $warehouse)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $warehouse->WARE_Name }}</td>
                            <td>{{ $warehouse->WARE_Address }}</td>
                            <td>{{ $warehouse->WARE_Phone }}</td>
                            <td>{{ $warehouse->WARE_Fax }}</td>
                            <td>{{ $warehouse->WARE_Email }}</td>
                            <td>{{ $warehouse->WARE_Web }}</td>
                            <td>{{ $warehouse->ware_note1 }}</td>
                            <td>{{ $warehouse->ware_note2 }}</td>
                            <td>{{ auth()->user()->name ?? '-' }}</td>
                            <td>{{ $warehouse->WARE_EntryDate ? \Carbon\Carbon::parse($warehouse->WARE_EntryDate)->format('d F Y') : '' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $warehouse->WARE_Auto }}"
                                    data-name="{{ $warehouse->WARE_Name }}"
                                    data-address="{{ $warehouse->WARE_Address }}"
                                    data-phone="{{ $warehouse->WARE_Phone }}"
                                    data-fax="{{ $warehouse->WARE_Fax }}"
                                    data-email="{{ $warehouse->WARE_Email }}"
                                    data-web="{{ $warehouse->WARE_Web }}"
                                    data-note1="{{ $warehouse->ware_note1 }}"
                                    data-note2="{{ $warehouse->ware_note2 }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                type="button"
                                class="btn btn-sm btn-danger delete-btn"
                                data-id="{{ $warehouse->WARE_Auto }}"
                                data-name="{{ $warehouse->WARE_Name ?? 'item ini' }}"
                                data-url="{{ route('warehouse.destroy', $warehouse->WARE_Auto) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="warehouseModal" tabindex="-1" aria-labelledby="warehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="warehouseForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warehouseModalLabel">Tambah Gudang</h5>
            </div>
                <div class="modal-body">
                    <fieldset class="border p-3">
                        <legend class="w-auto px-2 fw-bold">Master Warehouse</legend>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Gudang</label>
                            <div class="col-sm-9">
                                <input type="text" name="WARE_Name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea name="WARE_Address" class="form-control" rows="4"></textarea>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Telp</label>
                            <div class="col-sm-3">
                                <input type="text" name="WARE_Phone" class="form-control">
                            </div>
                            <label class="col-sm-2 col-form-label">e-mail</label>
                            <div class="col-sm-4">
                                <input type="email" name="WARE_Email" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Fax</label>
                            <div class="col-sm-3">
                                <input type="text" name="WARE_Fax" class="form-control">
                            </div>
                            <label class="col-sm-2 col-form-label">Web</label>
                            <div class="col-sm-4">
                                <input type="text" name="WARE_Web" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Catatan 1</label>
                            <div class="col-sm-9">
                                <input type="text" name="ware_note1" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Catatan 2</label>
                            <div class="col-sm-9">
                                <input type="text" name="ware_note2" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="submitbutton" class="btn btn-success">
                        <i class="bi bi-check-circle-fill"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- Script -->
@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();

    // Klik tombol "Tambah"
    $('.btn-primary').on('click', function() {
        $('#warehouseModalLabel').text('Tambah Gudang');
        $('#warehouseForm').attr('action', '{{ route('warehouse.store') }}');
        $('#formMethod').val('POST');
        $('#warehouseForm')[0].reset();
    });

    // Klik tombol "Edit"
    $('.edit-btn').on('click', function() {
        const modal = $('#warehouseModal');
        const form = $('#warehouseForm');

        $('#warehouseModalLabel').text('Edit Gudang');
        form.attr('action', `/warehouse/${$(this).data('id')}`);
        $('#formMethod').val('PUT');

        // Isi field dari data-attributes
        form.find('[name="WARE_Name"]').val($(this).data('name'));
        form.find('[name="WARE_Address"]').val($(this).data('address'));
        form.find('[name="WARE_Phone"]').val($(this).data('phone'));
        form.find('[name="WARE_Fax"]').val($(this).data('fax'));
        form.find('[name="WARE_Email"]').val($(this).data('email'));
        form.find('[name="WARE_Web"]').val($(this).data('web'));
        form.find('[name="ware_note1"]').val($(this).data('note1'));
        form.find('[name="ware_note2"]').val($(this).data('note2'));


        // Tampilkan modal
        modal.modal('show');
    });

    // Tampilkan modal
    $('.delete-btn').on('click', function (event) {
    event.preventDefault();

    const $button = $(this); // ✅ FIX di sini
    const id = $button.data('id');
    const itemName = $button.data('name') || 'item ini';
    const deleteUrl = $button.data('url'); // gunakan $button yang sudah didefinisikan
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    console.log({ id, deleteUrl, csrfToken });

    if (!id) {
        Swal.fire('Error!', 'ID tidak ditemukan.', 'error');
        return;
    }

    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: `Anda akan menghapus: <strong>${itemName}</strong><br><small>Tindakan ini tidak dapat dibatalkan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: csrfToken
                },
                success: function (response) {
                    Swal.fire('Terhapus!', response.message || 'Data berhasil dihapus.', 'success')
                        .then(() => location.reload());
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus.';
                    Swal.fire('Gagal!', message, 'error');
                }
            });
        }
    });
});
});

</script>
@endpush

