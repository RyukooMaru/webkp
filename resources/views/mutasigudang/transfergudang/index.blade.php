@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Transfer Gudang</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah -->
    <div class="mb-3">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Transfer
    </button>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transfer Gudang</h6>
        </div>
    <div class="card-body">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>No. Pengiriman</th>
                <th>Gudang Asal</th>
                <th>Gudang Tujuan</th>
                <th>Tanggal</th>
                <th>No. Permintaan</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transfers as $transfer)
            <tr>
                <td>{{ $transfer->Transfer_Number }}</td>
                <td>{{ $transfer->fromWarehouse->WARE_Name ?? '-' }}</td>
                <td>{{ $transfer->toWarehouse->WARE_Name ?? '-' }}</td>
                <td>{{ $transfer->Transfer_Date }}</td>
                <td>{{ $transfer->Transfer_ByEmp }}</td>
                <td>{{ $transfer->Transfer_Note }}</td>
                <td>
    <div class="d-flex gap-2">
        <button
            type="button"
            class="btn btn-sm btn-danger delete-btn"
            data-id="{{ $transfer->Transfer_Auto }}"
            data-name="{{ $transfer->Transfer_Number ?? 'item ini' }}"
            data-url="{{ route('transfergudang.destroy', $transfer->Transfer_Auto) }}">
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="form-transfer" method="POST" action="{{ route('transfergudang.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Transfer Gudang</h5>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>No. Pengiriman</label>
            <input type="text" name="Transfer_Number" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Gudang Asal</label>
            <select name="Transfer_FromWarehouse" class="form-control" required>
                <option value="">-- Pilih Gudang Asal --</option>
                @foreach($warehouses as $gudang)
                <option value="{{ $gudang->WARE_Auto }}">{{ $gudang->WARE_Name }}</option>
                @endforeach
            </select>
            </div>

            <div class="mb-3">
            <label>Gudang Tujuan</label>
            <select name="Transfer_ToWarehouse" class="form-control" required>
                <option value="">-- Pilih Gudang Tujuan --</option>
                @foreach($warehouses as $gudang)
                <option value="{{ $gudang->WARE_Auto }}">{{ $gudang->WARE_Name }}</option>
                @endforeach
            </select>
            </div>

          <div class="mb-3">
            <label>Tanggal Transfer</label>
            <input type="date" name="Transfer_Date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>No. Permintaan</label>
            <input type="text" name="Transfer_ByEmp" class="form-control">
          </div>

          <div class="mb-3">
            <label>Catatan</label>
            <textarea name="Transfer_Note" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();


    // delete modal
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
