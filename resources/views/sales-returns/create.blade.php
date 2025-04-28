@extends('layouts.admin')

@section('main-content')
    <div class="container-fluid">
        {{-- Judul --}}
        <h1 class="h3 font-weight-bold mb-4">Form Tambah Retur Penjualan</h1>

        {{-- Card Form Header --}}
        <div class="card mb-4">
            <div class="card-body">
                <form id="returnForm">
                    <div class="form-row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="returnNumber">No#</label>
                                <input type="text" id="returnNumber" name="trx_number" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select id="supplier" name="supplier_id" class="form-control">
                                    <option value="">-- Pilih Supplier --</option>
                                    {{-- @foreach ($suppliers as $s) --}}
                                    {{-- <option value="{{ $s->id }}">{{ $s->name }}</option> --}}
                                    {{-- @endforeach --}}
                                </select> {{-- custom select :contentReference[oaicite:5]{index=5} --}}
                            </div>
                            <div class="form-group">
                                <label for="warehouse">Gudang</label>
                                <select id="warehouse" name="ware_code" class="form-control">
                                    <option value="">-- Pilih Gudang --</option>
                                    {{-- @foreach ($warehouses as $w) --}}
                                    {{-- <option value="{{ $w->code }}">{{ $w->name }}</option> --}}
                                    {{-- @endforeach --}}
                                </select>
                            </div>
                        </div>
                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="returnDate">Tgl Retur</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="returnDate" name="Trx_Date" class="form-control"
                                        autocomplete="off">
                                </div> {{-- input group datepicker :contentReference[oaicite:6]{index=6} --}}
                            </div>
                            <div class="form-group">
                                <label for="note">Catatan</label>
                                <textarea id="note" name="Trx_Note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Detail Produk --}}
        <div class="card mb-4">
            <div class="card-body">
                <table id="detailsTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Disc</th>
                            <th>Pajak</th>
                            <th>Nominal</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- baris akan di-generate JS --}}
                    </tbody>
                </table>
                {{-- Ringkasan Totals --}}
                <div class="row text-right font-weight-bold">
                    <div class="col-md-3">Bruto:</div>
                    <div class="col-md-3">Disc:</div>
                    <div class="col-md-3">Pajak:</div>
                    <div class="col-md-3">Netto:</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3" id="totalBruto">0.00</div>
                    <div class="col-md-3" id="totalDisc">0.00</div>
                    <div class="col-md-3" id="totalPajak">0.00</div>
                    <div class="col-md-3" id="totalNetto">0.00</div>
                </div>

                {{-- Kontrol Bawah Tabel --}}
                <div class="d-flex justify-content-between align-items-center">
                    {{-- Page Length & Pagination --}}
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Tampilkan</span>
                        <select id="pageLength" class="custom-select custom-select-sm mr-3" style="width:auto;">
                            <option>2</option>
                            <option selected>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <nav>
                            <ul class="pagination mb-0"></ul>
                        </nav> {{-- Bootstrap pagination :contentReference[oaicite:7]{index=7} --}}
                    </div>
                    {{-- Tombol Aksi --}}
                    <div>
                        <button id="addRow" class="btn btn-success mr-2">
                            <i class="fas fa-plus"></i> Tambah Baris
                        </button>
                        <button id="delRow" class="btn btn-danger mr-2">
                            <i class="fas fa-minus"></i> Hapus Baris
                        </button>
                        <button id="saveData" class="btn btn-primary mr-2">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <button id="approve" class="btn btn-success mr-2">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                        <button id="cancel" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </div>
                    {{-- Info Baris --}}
                    <div id="tableInfo" class="small text-gray-600"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
