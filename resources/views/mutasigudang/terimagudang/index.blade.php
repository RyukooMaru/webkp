@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Terima Gudang</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            Tambah Penerimaan
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Terima Gudang</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                     <tr>
                        <!-- DIUBAH: Header tabel disesuaikan dengan data yang benar -->
                        <th>No. Penerimaan</th>
                        <th>No. Permintaan</th>
                        <th>Gudang Penerima</th>
                        <th>Gudang Pengirim</th>
                        <th>Tanggal</th>
                        <th>Catatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($td_gudangorder as $row)
                    <tr>
                        <!-- DIUBAH: Menampilkan data dari kolom yang benar -->
                        <td>{{ $row->Rec_ordernumber }}</td>
                        <td>{{ $row->pur_ordernumber }}</td>
                        <td>{{ $row->gudangPenerima->WARE_Name ?? 'ID: ' . $row->pur_warehouse }}</td>
                        <td>{{ $row->gudangPengirim->WARE_Name ?? 'ID: ' . $row->Pur_SupCode }}</td>
                        <td>{{ $row->Pur_Date }}</td>
                        <td>{{ $row->Pur_Note }}</td>
                        <td>
                            @if($row->Pur_Cancel === 'Y')
                                {{-- Jika sudah diapprove, tampilkan badge saja --}}
                                <span class="badge bg-success">Approved</span>
                            @else
                                {{-- Jika masih pending, tampilkan tombol approve di dalam form --}}
                                <form action="{{ route('terimagudang.approve', $row->Rec_Auto) }}" method="POST" class="approve-form d-inline">
                                    @csrf {{-- Token keamanan Laravel, wajib ada --}}
                                        <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Penerimaan --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('terimagudang.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Penerimaan Gudang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <!-- DIUBAH: Form disesuaikan 100% dengan kolom database -->
                        <div class="mb-3">
                            <label>No. Penerimaan</label>
                            <input type="text" name="Rec_ordernumber" class="form-control" value="{{ 'PNR-' . now()->format('YmdHis') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Gudang Penerima</label>
                            <select name="pur_warehouse" class="form-control" required>
                                <option value="">-- Pilih Gudang Penerima --</option>
                                @foreach($warehouses as $gudang)
                                    <option value="{{ $gudang->WARE_Auto }}">{{ $gudang->WARE_Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Gudang Pengirim</label>
                            <select name="Pur_SupCode" class="form-control" required>
                                <option value="">-- Pilih Gudang Pengirim --</option>
                                 @foreach($warehouses as $gudang)
                                    <option value="{{ $gudang->WARE_Auto }}">{{ $gudang->WARE_Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Penerimaan</label>
                            <input type="date" name="Pur_Date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>No. Permintaan / Order Asli</label>
                            <input type="text" name="pur_ordernumber" class="form-control" required placeholder="Masukkan nomor permintaan/order...">
                        </div>

                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="Pur_Note" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Listener untuk semua form dengan class 'approve-form'
    $('.approve-form').on('submit', function(event) {
        // 1. Mencegah form dikirim secara normal
        event.preventDefault();

        const form = $(this);
        const approveUrl = form.attr('action');
        const csrfToken = form.find('input[name="_token"]').val();
        const orderNumber = form.data('order-number'); // Ambil nomor order dari data attribute

        // 2. Tampilkan SweetAlert konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Anda akan menyetujui penerimaan: <strong>${orderNumber}</strong><br><small>Stok akan diperbarui dan tindakan ini tidak dapat dibatalkan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745', // Warna hijau untuk konfirmasi
            cancelButtonColor: '#d33'
        }).then((result) => {
            // 3. Jika pengguna menekan tombol "Ya, Setujui!"
            if (result.isConfirmed) {
                // Kirim request AJAX ke server
                $.ajax({
                    url: approveUrl,
                    type: 'POST',
                    data: {
                        _token: csrfToken
                        // Tidak perlu _method karena rute kita adalah POST
                    },
                    success: function (response) {
                        // Jika sukses, tampilkan pesan sukses dari SweetAlert
                        Swal.fire(
                            'Disetujui!',
                            response.message || 'Data berhasil disetujui.', // Gunakan pesan dari controller jika ada
                            'success'
                        ).then(() => {
                            // Muat ulang halaman untuk melihat perubahan
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        // Jika gagal, tampilkan pesan error
                        const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses data.';
                        Swal.fire(
                            'Gagal!',
                            message,
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endpush
