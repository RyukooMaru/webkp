@extends('layouts.admin')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <style>
        /* Pastikan tabel scroll horisontal di mobile */
        .table-responsive {
            overflow-x: auto;
        }

        /* Ikon sort di header */
        table.dataTable thead th {
            position: relative;
            cursor: pointer;
        }

        table.dataTable thead th:before {
            content: '↕';
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            opacity: .3;
        }

        table.dataTable thead th.sorting_asc:before {
            content: '↑';
            opacity: 1;
        }

        table.dataTable thead th.sorting_desc:before {
            content: '↓';
            opacity: 1;
        }
    </style>
@endpush

@section('main-content')
    <div class="container-fluid">
        <h1 class="h3 font-weight-bold mb-4">Daftar Retur Penjualan</h1>

        {{-- FILTER --}}
        <div class="form-row mb-3">
            <div class="col-sm-4 mb-2">
                <label class="font-weight-bold">Dari Tgl</label>
                <input type="date" id="dateStart" class="form-control">
            </div>
            <div class="col-sm-4 mb-2">
                <label class="font-weight-bold">Sampai Tgl</label>
                <input type="date" id="dateEnd" class="form-control">
            </div>
            <div class="col-sm-4 mb-2">
                <label class="font-weight-bold">Cari</label>
                <input type="text" id="searchBox" class="form-control" placeholder="Kata kunci...">
            </div>
        </div>

        {{-- TABEL RESPONSIF --}}
        <div class="table-responsive mb-3">
            <table id="returnsTable" class="table table-bordered table-hover w-100">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center"><i class="fas fa-pen"></i></th>
                        <th>Pelanggan</th>
                        <th>No#</th>
                        <th>Tgl Kembali</th>
                        <th>Bruto</th>
                        <th>Disc</th>
                        <th>Pajak</th>
                        <th>Netto</th>
                        <th>Pengguna</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        {{-- KONTROL --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            {{-- SHOW + LENGTH --}}
            <div class="d-flex align-items-center mb-2">
                <span class="mr-2">Tampilkan</span>
                <select id="pageLength" class="custom-select custom-select-sm mr-3" style="width:auto">
                    <option value="2">2</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>baris</span>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex align-items-center mb-2">
                <button id="prevPage" class="btn btn-outline-secondary btn-sm mr-2"><i
                        class="fas fa-chevron-left"></i></button>
                <input type="number" id="currentPage" class="form-control form-control-sm text-center" style="width:60px"
                    min="1">
                <span class="mx-2">/ <span id="totalPages">1</span></span>
                <button id="nextPage" class="btn btn-outline-secondary btn-sm ml-2"><i
                        class="fas fa-chevron-right"></i></button>
            </div>

            {{-- ACTIONS --}}
            <div class="mb-2">
                <a href="{{ route('sales-returns.create') }}" class="btn btn-success mr-2"><i class="fas fa-plus"></i>
                    Tambah</a>
                <button id="btn-edit" class="btn btn-warning mr-2" disabled><i class="fas fa-pen"></i> Ubah</button>
                <button id="btn-print" class="btn btn-info"><i class="fas fa-file"></i> Cetak</button>
            </div>

            {{-- INFO --}}
            <div id="tableInfo" class="small text-gray-600 mb-2"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            const table = $('#returnsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('sales-returns.data') }}',
                    data: function(d) {
                        return {
                            ...d,
                            date_start: $('#dateStart').val(),
                            date_end: $('#dateEnd').val(),
                            keyword: $('#searchBox').val()
                        };
                    }
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<i class="fas fa-pen row-toggle text-secondary" data-id="' + row
                                .Trx_Auto + '" style="cursor:pointer"></i>';
                        }
                    },
                    {
                        data: 'Trx_SupCode',
                        name: 'Trx_SupCode'
                    },
                    {
                        data: 'trx_number',
                        name: 'trx_number'
                    },
                    {
                        data: 'Trx_Date',
                        name: 'Trx_Date'
                    },
                    {
                        data: 'Trx_GrossPrice',
                        name: 'Trx_GrossPrice'
                    },
                    {
                        data: 'Trx_Discount',
                        name: 'Trx_Discount'
                    },
                    {
                        data: 'Trx_Taxes',
                        name: 'Trx_Taxes'
                    },
                    {
                        data: 'Trx_NettPrice',
                        name: 'Trx_NettPrice'
                    },
                    {
                        data: 'Trx_UserID',
                        name: 'Trx_UserID'
                    },
                    {
                        data: 'Trx_LastUpdate',
                        name: 'Trx_LastUpdate'
                    }
                ],
                order: [
                    [2, 'desc']
                ],
                lengthMenu: [
                    [2, 10, 25, 50],
                    [2, 10, 25, 50]
                ],
                pageLength: 2,
                dom: 't', // hanya menampilkan tabel saja, semua elemen bawaan dihilangkan
                pagingType: 'simple_numbers',
                language: {
                    processing: 'Memproses...',
                    infoFiltered: ''
                }
            });

            // Fungsi untuk memperbarui informasi dan status tombol navigasi
            function refresh() {
                const info = table.page.info();
                $('#currentPage').val(info.page + 1);
                $('#totalPages').text(info.pages);
                $('#prevPage').prop('disabled', info.page === 0);
                $('#nextPage').prop('disabled', info.page >= info.pages - 1);
                $('#tableInfo').text(`Menampilkan ${info.start+1}–${info.end} dari ${info.recordsTotal} entri`);
            }

            // Panggil refresh setelah tabel di-draw
            table.on('draw', refresh);

            // Refresh pertama kali
            refresh();

            // Filter berdasarkan tanggal dan keyword
            $('#dateStart, #dateEnd').on('change', function() {
                table.ajax.reload();
            });

            $('#searchBox').on('keyup', function() {
                table.ajax.reload();
            });

            // Ubah jumlah baris per halaman
            $('#pageLength').on('change', function() {
                table.page.len(parseInt($(this).val())).draw(false);
            });

            // Tombol navigasi halaman
            $('#prevPage').on('click', function() {
                if (!$(this).prop('disabled')) {
                    table.page('previous').draw(false);
                }
            });

            $('#nextPage').on('click', function() {
                if (!$(this).prop('disabled')) {
                    table.page('next').draw(false);
                }
            });

            // Input nomor halaman
            $('#currentPage').on('change', function() {
                let pageNum = parseInt($(this).val());
                if (isNaN(pageNum)) {
                    pageNum = 1;
                }

                // Batas minimum dan maksimum halaman
                const maxPage = table.page.info().pages;
                pageNum = Math.max(1, Math.min(maxPage, pageNum));

                // Pindah ke halaman yang diinginkan (index-based, jadi dikurangi 1)
                table.page(pageNum - 1).draw(false);
            });

            // Toggle untuk memilih baris
            $('#returnsTable tbody').on('click', '.row-toggle', function() {
                $('.row-toggle').not(this).removeClass('text-primary').addClass('text-secondary');
                $(this).toggleClass('text-primary').toggleClass('text-secondary');
                $('#btn-edit').prop('disabled', $('.row-toggle.text-primary').length === 0);
            });

            // Tombol edit
            $('#btn-edit').on('click', function() {
                const id = $('.row-toggle.text-primary').data('id');
                if (id) window.location.href = `/sales-returns/${id}/edit`;
            });

            // Tombol cetak
            $('#btn-print').on('click', function() {
                const params = $.param({
                    date_start: $('#dateStart').val(),
                    date_end: $('#dateEnd').val(),
                    keyword: $('#searchBox').val()
                });
                window.open(`{{ route('sales-returns.print') }}?${params}`, '_blank');
            });
        });
    </script>
@endpush
