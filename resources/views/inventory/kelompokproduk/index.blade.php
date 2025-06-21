@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Kelompok Produk</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" id="btnAddKelompok">
            <i class="fas fa-plus"></i> Tambah Kelompok
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="2%" class="text-center align-middle">No</th>
                            <th class="text-center align-middle">Nama Kelompok</th>
                            <th width="10%" class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompokProduks as $index => $kelompok)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kelompok->nama_kelompok }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn"
                                        data-id="{{ $kelompok->id }}"
                                        data-nama="{{ $kelompok->nama_kelompok }}"
                                        title="Edit Kelompok Produk">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn"
                                        data-id="{{ $kelompok->id }}"
                                        data-nama="{{ $kelompok->nama_kelompok }}"
                                        title="Hapus Kelompok Produk">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data kelompok produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal: Universal Modal for Add/Edit -->
    <div class="modal fade" id="universalModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="mainForm" method="POST" class="modal-content">
                @csrf
                <input type="hidden" id="id" name="id">
                @method('POST')

                <div class="modal-header py-2">
                    <h5 class="modal-title" id="modalTitle">Tambah Kelompok Produk</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                     </button>
                </div>

                <div class="modal-body p-2">
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="small mb-0">Nama Kelompok <span class="text-danger">*</span></label>
                            <input type="text" id="nama_kelompok" name="nama_kelompok" 
                                class="form-control form-control-sm" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3" id="modalSubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Atur vertikal tengah untuk semua sel */
    #dataTable th, 
    #dataTable td {
        vertical-align: middle !important;
    }
    
    /* Atur horizontal alignment */
    #dataTable th {
        text-align: center;
    }
    
    /* Kolom No dan Aksi di tengah */
    #dataTable td:first-child,
    #dataTable td:last-child {
        text-align: center;
    }
    
    /* Kolom Nama Kelompok rata kiri */
    #dataTable td:nth-child(2) {
        text-align: left;
    }
    
    /* Responsive design untuk mobile */
    @media (max-width: 768px) {
        #dataTable td:nth-child(2) {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(function() {
    const modalEl = document.getElementById('universalModal');
    const modalInstance = new bootstrap.Modal(modalEl);
    const form = $('#mainForm');
    const baseInventoryUrl = "{{ url('inventory') }}"; // Get base URL for inventory


    $('#dataTable').DataTable();

    // Tambah Data
    $('#btnAddKelompok').click(() => {
        form.trigger('reset');
        $('#modalTitle').text('Tambah Kelompok Produk Baru');
        $('#modalSubmit').text('Simpan');
        form.attr('action', `${baseInventoryUrl}/kelompokproduk`); // Corrected for store
        form.find('input[name="_method"]').val('POST');
        modalInstance.show();
    });

    // Edit Data
    $('#dataTable').on('click', '.edit-btn', function() {
        const btn = $(this);
        form.attr('action', `${baseInventoryUrl}/kelompokproduk/${btn.data('id')}`);
        form.find('input[name="_method"]').val('PUT');
        $('#id').val(btn.data('id'));
        $('#nama_kelompok').val(btn.data('nama'));
        $('#modalTitle').text('Edit Kelompok Produk');
        $('#modalSubmit').text('Simpan Perubahan');
        modalInstance.show();
    });

    // Submit Form
    form.on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: form.attr('action'),
            method: form.find('input[name="_method"]').val(),
            data: form.serialize(),
            success: function(response) {
                modalInstance.hide();
                Swal.fire('Berhasil', response.message, 'success');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let messages = '';
                    Object.values(errors).forEach(arr => arr.forEach(msg => messages += msg + '<br>'));
                    Swal.fire('Error', messages, 'error');
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            }
        });
    });

    // Hapus Data
    $('#dataTable').on('click', '.delete-btn', function() {
        const btn = $(this);
        const id = btn.data('id');
        const nama = btn.data('nama');
        const row = btn.parents('tr');

        Swal.fire({
            title: 'Hapus Kelompok Produk?',
            html: `Yakin ingin menghapus kelompok produk <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('kelompokproduk.destroy', '') }}/${id}`,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        row.fadeOut(400, function() {
                            row.remove();
                        });
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            html: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan pada server';

                        if (xhr.status === 404) {
                            message = 'Data kelompok produk tidak ditemukan';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: message,
                            timer: 3000,
                            showConfirmButton: true
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
