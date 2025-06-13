@extends('layouts.admin')

@section('main-content')
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Form Retur Penjualan</h6>
            </div>
            <div class="card-body">
                <form id="headerForm">@csrf
                    <input type="hidden" id="draftId" value="{{ $header->Trx_Auto }}">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">No. Retur</label>
                        <div class="col-sm-4">
                            <input type="text" id="trxNumber" name="trx_number" class="form-control"
                                value="{{ $header->trx_number }}" readonly>
                        </div>
                        <label class="col-sm-2 col-form-label">Tanggal Retur</label>
                        <div class="col-sm-4">
                            <input type="date" name="Trx_Date" id="Trx_Date" class="form-control"
                                value="{{ old('Trx_Date', $header->Trx_Date?->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Pelanggan</label>
                        <div class="col-sm-4">
                            <select name="Trx_SupCode" id="Trx_SupCode" class="form-control" required>
                                <option value="">Pilih…</option>
                                <option value="SP-A"
                                    {{ old('Trx_SupCode', $header->Trx_SupCode) === 'SP-A' ? 'selected' : '' }}>SP-A
                                </option>
                                <option value="SP-B"
                                    {{ old('Trx_SupCode', $header->Trx_SupCode) === 'SP-B' ? 'selected' : '' }}>SP-B
                                </option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Gudang</label>
                        <div class="col-sm-4">
                            <select name="Trx_WareCode" id="Trx_WareCode" class="form-control" required>
                                <option value="">Pilih…</option>
                                <option value="WH-A"
                                    {{ old('Trx_WareCode', $header->Trx_WareCode) === 'WH-A' ? 'selected' : '' }}>WH-A
                                </option>
                                <option value="WH-B"
                                    {{ old('Trx_WareCode', $header->Trx_WareCode) === 'WH-B' ? 'selected' : '' }}>WH-B
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Catatan</label>
                        <div class="col-sm-10">
                            <textarea name="Trx_Note" id="Trx_Note" class="form-control" rows="2">{{ old('Trx_Note', $header->Trx_Note) }}</textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mb-3 d-flex">
            <button type="button" id="addCodeButton" class="btn btn-primary mr-2" data-bs-toggle="modal"
                data-bs-target="#dtlModal">
                <i class="fas fa-plus"></i>
            </button>
            <button id="btnPublish" class="btn btn-info mr-2">
                <i class="fas fa-floppy-disk"></i>
            </button>
            <button id="btnCancelDraft" class="btn btn-danger mr-2">
                <i class="fas fa-times"></i>
            </button>
            <a href="{{ route('retur.penjualan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive pb-3">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width='10%'>Kode</th>
                                <th width='10%'>Nama Produk</th>
                                <th width='5%'>Qty</th>
                                <th width='5%'>Satuan</th>
                                <th width='10%'>Harga Jual</th>
                                <th width='10%'>Disc (%)</th>
                                <th width='10%'>Pajak (%)</th>
                                <th width='10%'>Nominal</th>
                                <th width='20%'>Catatan</th>
                                <th width='10%'>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- isi akan di-render via AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="dtlModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="dtlForm" onsubmit="return false;">@csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Kode</label>
                                <div class="col-sm-10">
                                    <input name="Trx_ProdCode" id="Trx_ProdCode" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input name="trx_prodname" id="trx_prodname" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-4">
                                    <select name="trx_uom" id="trx_uom" class="form-control" required>
                                        <option value="">Pilih…</option>
                                        <option value="PCS">PCS</option>
                                        <option value="BOX">BOX</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Harga Jual</label>
                                <div class="col-sm-4">
                                    <input type="number" min="1000" step="1000" name="Trx_GrossPrice"
                                        id="Trx_GrossPrice" class="form-control calc-trigger" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Pajak (%)</label>
                                <div class="col-sm-4">
                                    <input type="number" min="0" step="0.1" name="Trx_Taxes" id="Trx_Taxes"
                                        class="form-control calc-trigger" required>
                                </div>
                                <label class="col-sm-2 col-form-label">Potongan (%)</label>
                                <div class="col-sm-4">
                                    <input type="number" min="0" step="0.1" name="Trx_Discount"
                                        id="Trx_Discount" class="form-control calc-trigger" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Qty</label>
                                <div class="col-sm-4">
                                    <input type="number" min="1" name="Trx_QtyTrx" id="Trx_QtyTrx"
                                        class="form-control calc-trigger" required>
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" id="Trx_NettPrice" name="Trx_NettPrice" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Catatan</label>
                                <div class="col-sm-10">
                                    <textarea name="Trx_NoteDetail" id="Trx_NoteDetail" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="dtlSave" type="button" class="btn btn-primary">
                                <i class="fas fa-check"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            // Ambil headerId dari backend (diberikan oleh controller)
            const headerId = {{ $header->Trx_Auto }};
            let editMode = false,
                currentDetailId = null;

            // Hitung otomatis harga bersih di modal
            $('.calc-trigger').on('input', calculateNettPrice);

            function calculateNettPrice() {
                const qty = parseFloat($('#Trx_QtyTrx').val()) || 0;
                const grossPrice = parseFloat($('#Trx_GrossPrice').val()) || 0;
                const discountPercent = parseFloat($('#Trx_Discount').val()) || 0;
                const taxesPercent = parseFloat($('#Trx_Taxes').val()) || 0;

                // Hitung subtotal (harga * qty)
                const subtotal = qty * grossPrice;

                // Terapkan persentase diskon dan pajak
                const discountAmount = subtotal * (discountPercent / 100);
                const afterDiscount = subtotal - discountAmount;
                const taxAmount = afterDiscount * (taxesPercent / 100);

                // Hitung harga akhir
                const total = afterDiscount + taxAmount;
                $('#Trx_NettPrice').val(total.toFixed(2));
            }

            // Pembaruan Header yang Dibatasi - untuk menghindari panggilan AJAX yang terlalu sering
            let headerUpdateTimer;
            $('#headerForm').on('change', 'input, textarea, select', function() {
                clearTimeout(headerUpdateTimer);
                headerUpdateTimer = setTimeout(updateHeader, 500);
            });

            function updateHeader() {
                if (!validateHeaderForm()) {
                    return;
                }

                const data = $('#headerForm').serialize();
                $.ajax({
                    url: `/retur/penjualan/${headerId}`,
                    type: 'PUT',
                    data: data,
                    success: function(response) {
                        console.log('Header berhasil diperbarui');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Gagal memperbarui header: ' + xhr.responseText, 'error');
                    }
                });
            }

            // Validasi formulir header
            function validateHeaderForm() {
                let isValid = true;
                $('#headerForm [required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                return isValid;
            }

            // Inisialisasi DataTable DETAIL
            const detailTable = $('#dataTable').DataTable({
                ajax: {
                    url: `/retur/penjualan/${headerId}/details`,
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'Trx_ProdCode'
                    },
                    {
                        data: 'trx_prodname'
                    },
                    {
                        data: 'Trx_QtyTrx'
                    },
                    {
                        data: 'trx_uom'
                    },
                    {
                        data: 'Trx_GrossPrice',
                        render: function(data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'Trx_Discount',
                        render: function(data) {
                            return parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'Trx_Taxes',
                        render: function(data) {
                            return parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'Trx_NettPrice',
                        render: function(data) {
                            return parseFloat(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'Trx_Note'
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-sm btn-warning edit-btn mb-1" data-id="${row.Trx_Auto || row.trx_number_dtl}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn mb-1" data-id="${row.Trx_Auto || row.trx_number_dtl}">
                                <i class="fas fa-trash"></i>
                            </button>`;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                drawCallback: function() {
                    // Mengaktifkan/menonaktifkan tombol berdasarkan apakah ada data
                    const hasRecords = this.api().data().length > 0;
                    $('#btnPublish').prop('disabled', !hasRecords);
                }
            });

            // Tambah DETAIL (buka modal kosong)
            $('#addCodeButton').click(function() {
                // Periksa apakah header valid terlebih dahulu
                if (!validateHeaderForm()) {
                    Swal.fire('Perhatian', 'Harap lengkapi data header terlebih dahulu', 'warning');
                    return;
                }

                // Perbarui header terlebih dahulu untuk memastikan disimpan
                updateHeader();

                // Reset form and buka modal
                editMode = false;
                currentDetailId = null;
                $('#dtlForm')[0].reset();

                // Atur nilai default
                $('#Trx_QtyTrx').val(1);
                $('#Trx_GrossPrice').val(0);
                $('#Trx_Discount').val(0);
                $('#Trx_Taxes').val(0);
                $('#Trx_NettPrice').val(0);

                $('#dtlModal').modal('show');
            });

            // Simpan atau Update DETAIL
            $('#dtlSave').click(async function() {
                // Validasi form detail
                if (!validateDetailForm()) {
                    return;
                }

                calculateNettPrice(); // Hitung sekali lagi untuk memastikan harga bersih sudah benar

                const payload = $('#dtlForm').serialize();

                try {
                    if (editMode) {
                        // UPDATE
                        await $.ajax({
                            url: `/retur/penjualan/${headerId}/details/${currentDetailId}`,
                            type: 'PUT',
                            data: payload
                        });
                    } else {
                        // CREATE
                        await $.post(
                            `/retur/penjualan/${headerId}/details`,
                            payload
                        );
                    }
                } catch (e) {
                    return Swal.fire('Error', 'Gagal simpan detail: ' + (e.responseText ||
                        'Unknown error'), 'error');
                }

                $('#dtlModal').modal('hide');
                detailTable.ajax.reload(null, false);
                editMode = false;
                currentDetailId = null;

                // Pesan sukses dengan penutupan otomatis
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Item berhasil disimpan',
                    icon: 'success',
                    timer: 5000,
                    showConfirmButton: false
                })
            });

            // Validasi formulir detail
            function validateDetailForm() {
                let isValid = true;
                $('#dtlForm [required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Validasi tambahan untuk kolom numerik
                if (parseFloat($('#Trx_QtyTrx').val()) <= 0) {
                    $('#Trx_QtyTrx').addClass('is-invalid');
                    isValid = false;
                }

                if (parseFloat($('#Trx_GrossPrice').val()) <= 0) {
                    $('#Trx_GrossPrice').addClass('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    Swal.fire('Perhatian', 'Harap lengkapi semua data yang diperlukan', 'warning');
                }

                return isValid;
            }

            // Prefill EDIT DETAIL
            $('#dataTable').on('click', '.edit-btn', function() {
                editMode = true;
                currentDetailId = $(this).data('id');

                // Ambil data row
                const rowIdx = detailTable.row($(this).closest('tr')).index();
                const row = detailTable.row(rowIdx).data();

                // Atur ulang formulir terlebih dahulu
                $('#dtlForm')[0].reset();

                // Isi kolom formulir
                $('#Trx_ProdCode').val(row.Trx_ProdCode);
                $('#trx_prodname').val(row.trx_prodname);
                $('#trx_uom').val(row.trx_uom);
                $('#Trx_QtyTrx').val(row.Trx_QtyTrx);
                $('#Trx_GrossPrice').val(row.Trx_GrossPrice);
                $('#Trx_Discount').val(row.Trx_Discount);
                $('#Trx_Taxes').val(row.Trx_Taxes);
                $('#Trx_NettPrice').val(row.Trx_NettPrice);
                $('#Trx_NoteDetail').val(row.Trx_Note);

                $('#dtlModal').modal('show');
            });

            // HAPUS DETAIL
            $('#dataTable').on('click', '.delete-btn', function() {
                const detailId = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus item?',
                    text: "Item yang dihapus tidak dapat dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: `/retur/penjualan/${headerId}/details/${detailId}`,
                        type: 'DELETE'
                    }).done(() => {
                        detailTable.ajax.reload(null, false);

                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Item berhasil dihapus',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    }).fail((xhr) => {
                        Swal.fire('Error', 'Gagal menghapus item: ' + xhr.responseText,
                            'error');
                    });
                });
            });

            // BATALKAN DRAFT (hapus header & cascade detail)
            $('#btnCancelDraft').click(function() {
                Swal.fire({
                    title: 'Batalkan seluruh draft?',
                    text: "Semua data yang sudah diinput akan dihapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, batalkan!',
                    cancelButtonText: 'Tidak'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: `/retur/penjualan/${headerId}`,
                        type: 'DELETE'
                    }).done(() => {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Draft telah dibatalkan',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href =
                                '{{ route('retur.penjualan.index') }}';
                        });
                    }).fail((xhr) => {
                        Swal.fire('Error', 'Gagal membatalkan draft: ' + xhr.responseText,
                            'error');
                    });
                });
            });

            // PUBLISH DRAFT (ubah posting ke F)
            $('#btnPublish').click(function() {
                // Periksa apakah ada setidaknya satu item
                if (detailTable.data().count() === 0) {
                    Swal.fire('Perhatian',
                        'Tidak dapat menyimpan draft kosong. Tambahkan minimal satu item.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Simpan Retur Penjualan?',
                    text: "Pastikan data sudah benar",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: `/retur/penjualan/${headerId}/publish`,
                        type: 'PUT'
                    }).done(() => {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Retur Penjualan telah disimpan',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href =
                                '{{ route('retur.penjualan.index') }}';
                        });
                    }).fail((xhr) => {
                        Swal.fire('Error', xhr.responseJSON?.message ||
                            'Gagal menyimpan draft', 'error');
                    });
                });
            });

            // Periksa apakah memiliki rincian saat halaman dimuat untuk mengaktifkan/mematikan tombol
            $.get(`/retur/penjualan/${headerId}/details`, function(response) {
                const hasDetails = response.data && response.data.length > 0;
                $('#btnPublish').prop('disabled', !hasDetails);
            });
        });
    </script>
@endpush
