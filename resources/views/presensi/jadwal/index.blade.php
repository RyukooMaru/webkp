@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Jadwal dan Data Master</h1>

    <div class="row">
        <!-- Kolom Kiri: Manajemen Shift dan Libur -->
        <div class="col-lg-5">
            <!-- Card Manajemen Shift -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Master Shift</h6>
                </div>
                <div class="card-body">
                    <button id="btn-tambah-shift" class="btn btn-primary btn-sm mb-3"><i class="fas fa-plus"></i> Tambah Shift Baru</button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="shiftTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="1%">Kode</th>
                                    <th width="2%">Nama</th>
                                    <th width="2%">Jam In</th>
                                    <th width="2%">Jam Out</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shifts as $shift)
                                <tr>
                                    <td>{{ $shift->shift_code }}</td>
                                    <td>{{ $shift->shift_name }}</td>
                                    <td>{{ $shift->jam_in }}</td>
                                    <td>{{ $shift->jam_out }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit btn-edit-shift" data-id="{{ $shift->id }}" title="Edit Shift">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $shift->id }}" data-nama="{{ $shift->shift_name }}" title="Hapus Shift">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card Manajemen Libur Nasional -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Manajemen Libur Nasional</h6>
                </div>
                <div class="card-body">
                    <button id="btn-tambah-libur" class="btn btn-primary btn-sm mb-3"><i class="fas fa-plus"></i> Tambah Libur Baru</button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="holidayTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">Tanggal</th>
                                    <th width="10%">Keterangan</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($holidays as $holiday)
                                <tr>
                                    <td>{{ $holiday->tanggal }}</td>
                                    <td>{{ $holiday->keterangan }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit btn-edit-holiday" data-id="{{ $holiday->id }}" title="Edit Libur Nasional">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $holiday->id }}" data-nama="{{ $holiday->keterangan }}" title="Hapus Libur Nasional">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Manajemen Jadwal -->
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Tampilan Jadwal</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4 form-group mb-0"><label for="periode">Periode:</label><input type="month" id="periode" class="form-control" value="{{ date('Y-m') }}"></div>
                        <div class="col-md-4 form-group mb-0">
                            <label for="divisi">Divisi:</label>
                            <select id="divisi" class="form-control">
                                <option value="">Pilih Divisi</option>
                                @foreach($divisi as $div)
                                <option value="{{ $div->div_auto }}">{{ $div->Div_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><button id="btn-tampilkan" class="btn btn-primary w-100">Tampilkan</button></div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Jadwal</h6>
                    <button id="btn-modal-generate" class="btn btn-success" data-toggle="modal" data-target="#generateModal" disabled>
                        <i class="fas fa-cogs"></i> Generate Jadwal
                    </button>
                </div>
                <div class="card-body">
                    <div id="loading" style="display: none;" class="text-center my-5">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                        <p class="mt-2">Memuat Jadwal...</p>
                    </div>
                    <div id="schedule-container" class="table-responsive">
                        <p class="text-center text-muted">Pilih periode dan divisi untuk menampilkan jadwal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Masters Shift -->
<div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="shiftForm">
                <input type="hidden" name="_method" id="shift_formMethod" value="POST">
                <input type="hidden" name="id" id="Shift_Id" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="shiftModalLabel">Form Shift</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="form_shift_code">Kode Shift</label>
                        <input type="text" name="shift_code" id="form_shift_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="form_shift_name">Nama Shift</label>
                        <input type="text" name="shift_name" id="form_shift_name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label for="form_jam_in">Jam Masuk</label>
                            <input type="time" name="jam_in" id="form_jam_in" class="form-control" required>
                        </div>
                        <div class="col-6 form-group">
                            <label for="form_jam_out">Jam Pulang</label>
                            <input type="time" name="jam_out" id="form_jam_out" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanShift">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Libur Nasional -->
<div class="modal fade" id="holidayModal" tabindex="-1" aria-labelledby="holidayModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
            <form id="holidayForm">
                {{-- PERBAIKAN: Gunakan ID unik untuk field method --}}
                <input type="hidden" name="_method" id="holiday_formMethod" value="POST">
                <input type="hidden" name="id" id="Holiday_Id" value="">
                <div class="modal-header" >
                    <h5 class="modal-title" id="holidayModalLabel">Form Libur Nasional</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="form_tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="form_tanggal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="form_keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="form_keterangan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanHoliday">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jadwal Harian -->
<div class="modal fade" id="editShiftModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Jadwal Harian</h5><button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button></div>
            <div class="modal-body">
                <input type="hidden" id="edit_jadwal_id">
                <div class="form-group"><label for="edit_shift_code">Shift</label><select id="edit_shift_code" class="form-control"></select></div>
                <div class="form-group"><label for="edit_jam_in">Jam Masuk</label><input type="time" id="edit_jam_in" class="form-control"></div>
                <div class="form-group"><label for="edit_jam_out">Jam Pulang</label><input type="time" id="edit_jam_out" class="form-control"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="button" id="btn-save-shift" class="btn btn-primary">Simpan</button></div>
        </div>
    </div>
</div>

<!-- Modal Generate Jadwal -->
<div class="modal fade" id="generateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Generate Jadwal</h5><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button></div>
            <div class="modal-body">
                <p>Pilih periode, karyawan, dan shift default.</p>
                <div class="form-group">
                    <label for="generate-periode">Periode:</label>
                    <input type="month" id="generate-periode" class="form-control" value="{{ date('Y-m') }}">
                </div>
                <div class="form-group">
                    <label for="generate-holiday-shift">Shift Hari Libur Default</label>
                    <select id="generate-holiday-shift" class="form-control">
                         @foreach($shifts as $shift)
                            <option value="{{ $shift->shift_code }}" {{ $shift->shift_code == 'L' ? 'selected' : '' }}>{{ $shift->shift_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="generate-work-shift">Shift Hari Kerja Default</label>
                    <select id="generate-work-shift" class="form-control">
                        @foreach($shifts->where('shift_code', '!=', 'L') as $shift)
                            <option value="{{ $shift->shift_code }}" {{ $shift->shift_code == 'P1' ? 'selected' : '' }}>{{ $shift->shift_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Karyawan dari Divisi Terpilih:</label>
                    <div id="employee-list-container" class="border rounded p-2" style="max-height: 200px; overflow-y: auto;"><p class="text-muted small">Pilih divisi di halaman utama terlebih dahulu.</p></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button><button type="button" id="btn-generate-confirm" class="btn btn-primary">Generate</button></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // === PERBAIKAN 1: SETUP CSRF TOKEN UNTUK SEMUA AJAX REQUEST ===
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var shiftTable = $('#shiftTable').DataTable();
    var holidayTable = $('#holidayTable').DataTable(); // Asumsi ID tabel libur adalah dataTable2

    // --- LOGIKA UNTUK MASTER SHIFT ---
    $('#btn-tambah-shift').click(function () {
        $('#shiftForm').trigger("reset");
        $('#Shift_Id').val('');
        $('#shift_formMethod').val('POST'); // Targetkan ID yang unik
        $('#shiftModalLabel').text('Tambah Shift Baru');
        $('#btnSimpanShift').text('Simpan');
        $('#shiftModal').modal('show');
    });

    $('body').on('click', '.btn-edit-shift', function() {
        var shiftId = $(this).data('id');
        var row = $(this).closest('tr');
        var shiftCode = row.find('td').eq(0).text();
        var shiftName = row.find('td').eq(1).text();
        var jamIn = row.find('td').eq(2).text();
        var jamOut = row.find('td').eq(3).text();

        $('#shiftModalLabel').text('Edit Data Shift');
        $('#btnSimpanShift').text('Update');
        $('#shift_formMethod').val('PUT'); // Targetkan ID yang unik
        
        $('#Shift_Id').val(shiftId);
        $('#form_shift_code').val(shiftCode);
        $('#form_shift_name').val(shiftName);
        $('#form_jam_in').val(jamIn);
        $('#form_jam_out').val(jamOut);

        $('#shiftModal').modal('show');
    });

    $('#shiftForm').submit(function (e) {
        e.preventDefault();
        var shiftId = $('#Shift_Id').val();
        var method = $('#shift_formMethod').val(); 
        var url = (method === 'PUT') ? `/presensi/shift/${shiftId}` : "{{ route('shift.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                $('#shiftModal').modal('hide');
                Swal.fire('Berhasil', data.message || data.success, 'success').then(() => {
                    location.reload(); 
                });
            },
            error: function (xhr) {
                let errorHtml = '<ul class="text-left mb-0">';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value){
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                } else {
                    errorHtml += '<li>Terjadi kesalahan. Periksa console untuk detail.</li>';
                }
                errorHtml += '</ul>';
                Swal.fire({ title: 'Gagal Menyimpan!', html: errorHtml, icon: 'error' });
            }
        });
    });

    // --- LOGIKA UNTUK LIBUR NASIONAL ---
    $('#btn-tambah-libur').click(function () {
        $('#holidayForm').trigger("reset");
        $('#Holiday_Id').val('');
        $('#holiday_formMethod').val('POST'); // Targetkan ID yang unik
        $('#holidayModalLabel').text('Tambah Libur Baru');
        $('#btnSimpanHoliday').text('Simpan');
        $('#holidayModal').modal('show');
    });

    // Anda perlu menambahkan kelas .btn-edit-holiday pada tombol edit di tabel libur
    $('body').on('click', '.btn-edit-holiday', function() {
        var holidayId = $(this).data('id');
        var row = $(this).closest('tr');
        var tanggal = row.find('td').eq(0).text();
        var keterangan = row.find('td').eq(1).text();
        
        $('#holidayModalLabel').text('Edit Libur Nasional');
        $('#btnSimpanHoliday').text('Update');
        $('#holiday_formMethod').val('PUT'); // Targetkan ID yang unik

        $('#Holiday_Id').val(holidayId);
        // Perlu konversi format tanggal jika tidak YYYY-MM-DD
        // Jika formatnya 'DD MMMM YYYY', perlu diubah
        // Untuk sementara kita asumsikan formatnya sudah benar
        $('#form_tanggal').val(tanggal); 
        $('#form_keterangan').val(keterangan);

        $('#holidayModal').modal('show');
    });

    $('#holidayForm').submit(function (e) {
        e.preventDefault();
        var holidayId = $('#Holiday_Id').val();
        var method = $('#holiday_formMethod').val();
        var url = (method === 'PUT') ? `/presensi/holiday/${holidayId}` : "{{ route('holiday.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                $('#holidayModal').modal('hide');
                Swal.fire('Berhasil', data.message || 'Data berhasil disimpan.', 'success').then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                 let errorHtml = '<ul class="text-left mb-0">';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value){
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                } else {
                    errorHtml += '<li>Terjadi kesalahan. Periksa console untuk detail.</li>';
                }
                errorHtml += '</ul>';
                Swal.fire({ title: 'Gagal Menyimpan!', html: errorHtml, icon: 'error' });
            }
        });
    });

    // 1. Event Listener untuk Tombol Hapus SHIFT
    $('#shiftTable tbody').on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        const itemName = $(this).data('nama');
        const deleteUrl = `{{ url('presensi/shift') }}/${id}`;
        
        // Panggil fungsi konfirmasi universal
        confirmAndDelete(deleteUrl, itemName);
    });
    
    // 2. Event Listener untuk Tombol Hapus LIBUR NASIONAL
    $('#holidayTable tbody').on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        const itemName = $(this).data('nama');
        const deleteUrl = `{{ url('presensi/holiday') }}/${id}`;
        
        // Panggil fungsi konfirmasi universal
        confirmAndDelete(deleteUrl, itemName);
    });

    // 3. Fungsi Konfirmasi dan Hapus Universal dengan SweetAlert
    function confirmAndDelete(deleteUrl, itemName) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Anda akan menghapus: <strong>${itemName}</strong>.<br><small>Tindakan ini tidak dapat dibatalkan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: csrfToken
                    },
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            response.success || 'Data berhasil dihapus.',
                            'success'
                        ).then(() => {
                            // Reload halaman untuk melihat perubahan
                            location.reload(); 
                        });
                    },
                    error: function(jqXHR) {
                        let errorMsg = 'Gagal menghapus data.';
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMsg = jqXHR.responseJSON.message;
                        }
                        Swal.fire('Gagal!', errorMsg, 'error');
                    }
                });
            }
        });
    }

    const masterShifts = @json($shifts->keyBy('shift_code'));
    let scheduleTable;

    // --- LOGIKA MANAJEMEN JADWAL ---

    // 1. Tampilkan Jadwal
    $('#btn-tampilkan').on('click', function() {
        const periode = $('#periode').val();
        const divisiId = $('#divisi').val();

        if (!periode || !divisiId) {
            Swal.fire('Peringatan', 'Silakan pilih periode dan divisi.', 'warning');
            return;
        }

        $('#loading').show();
        $('#schedule-container').html('');
        $('#btn-modal-generate').prop('disabled', true);

        $.ajax({
            url: '{{ route("jadwal.fetch") }}',
            method: 'POST',
            data: { periode: periode, divisi_id: divisiId },
            success: function(response) {
                renderScheduleTable(response.schedules, response.employees, periode);
                populateEmployeeList(response.employees);
                $('#btn-modal-generate').prop('disabled', false);
            },
            error: () => Swal.fire('Error', 'Gagal memuat data jadwal.', 'error'),
            complete: () => $('#loading').hide()
        });
    });

    // 2. Render Tabel Jadwal
    function renderScheduleTable(schedules, employees, periode) {
        const daysInMonth = new Date(periode.split('-')[0], periode.split('-')[1], 0).getDate();
        let tableHtml = `<table class="table table-bordered table-hover table-sm text-center" id="scheduleDataTable" style="font-size: 0.8rem;">`;
        let header = '<thead><tr><th style="min-width: 150px;">Nama Karyawan</th>';
        for (let day = 1; day <= daysInMonth; day++) header += `<th>${day}</th>`;
        header += '<th>Aksi</th></tr></thead>';

        let body = '<tbody>';
        employees.forEach(employee => {
            body += `<tr><td class="text-left text-nowrap">${employee.emp_Name}</td>`;
            const employeeSchedules = schedules[employee.emp_Auto] || [];

            for (let day = 1; day <= daysInMonth; day++) {
                const schedule = employeeSchedules.find(s => parseInt(s.emp_tgl) === day);
                body += `<td class="schedule-cell" data-id="${schedule ? schedule.tmp_auto : ''}" data-shift-code="${schedule ? schedule.shift_code : ''}" style="cursor: pointer;" title="Klik untuk ubah">${schedule ? schedule.shift_code : '-'}</td>`;
            }
            body += `<td><button class="btn btn-danger btn-sm btn-delete-schedule" data-employee-id="${employee.emp_Auto}" data-employee-name="${employee.emp_Name}" title="Hapus Jadwal Bulan Ini"><i class="fas fa-trash"></i></button></td></tr>`;
        });
        body += '</tbody>';

        tableHtml += header + body + '</table>';
        $('#schedule-container').html(tableHtml);

        // Inisialisasi DataTables
        if ($.fn.DataTable.isDataTable('#scheduleDataTable')) {
            $('#scheduleDataTable').DataTable().destroy();
        }
        scheduleTable = $('#scheduleDataTable').DataTable({
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            searching: false,
            info: false,
            ordering: false,
        });
    }

    // 3. Populate Modal Generate
    function populateEmployeeList(employees) {
        const container = $('#employee-list-container');
        container.empty();
        if (employees.length > 0) {
            container.append('<div class="mb-2"><input type="checkbox" id="check-all-employees"> <label for="check-all-employees">Pilih Semua</label></div>');
            employees.forEach(e => container.append(`<div class="form-check"><input class="form-check-input employee-checkbox" type="checkbox" value="${e.emp_Auto}" id="emp-${e.emp_Auto}"><label class="form-check-label" for="emp-${e.emp_Auto}">${e.emp_Name}</label></div>`));
        } else {
            container.html('<p class="text-muted small">Tidak ada karyawan di divisi ini.</p>');
        }
    }
    
    $(document).on('click', '#check-all-employees', function() {
        $('.employee-checkbox').prop('checked', $(this).is(':checked'));
    });

    // 4. Generate Jadwal
    $('#btn-generate-confirm').on('click', function() {
        const periode = $('#generate-periode').val();
        const employeeIds = $('.employee-checkbox:checked').map((_, el) => $(el).val()).get();

        if (employeeIds.length === 0) {
            Swal.fire('Peringatan', 'Pilih minimal satu karyawan.', 'warning');
            return;
        }
        
        $(this).prop('disabled', true).text('Memproses...');

        $.ajax({
            url: '{{ route("jadwal.generate") }}',
            method: 'POST',
            data: {
                periode: periode,
                employee_ids: employeeIds,
                default_work_shift: $('#generate-work-shift').val(),
                default_holiday_shift: $('#generate-holiday-shift').val()
            },
            success: (response) => {
                $('#generateModal').modal('hide');
                Swal.fire('Berhasil', response.message, 'success');
                $('#btn-tampilkan').click();
            },
            error: (xhr) => Swal.fire('Error', xhr.responseJSON.message || 'Terjadi kesalahan.', 'error'),
            complete: () => $(this).prop('disabled', false).text('Generate')
        });
    });

    // 5. Buka Modal Edit Jadwal Harian
    $('#schedule-container').on('click', '.schedule-cell', function() {
        const id = $(this).data('id');
        if (!id) return;

        const shiftCode = $(this).data('shift-code');
        const dropdown = $('#edit_shift_code');
        dropdown.empty();
        Object.values(masterShifts).forEach(s => {
            dropdown.append(`<option value="${s.shift_code}" ${s.shift_code == shiftCode ? 'selected' : ''}>${s.shift_name} (${s.shift_code})</option>`);
        });

        const shiftData = masterShifts[shiftCode];
        $('#edit_jadwal_id').val(id);
        $('#edit_jam_in').val(shiftData ? shiftData.jam_in.substring(0,5) : '00:00');
        $('#edit_jam_out').val(shiftData ? shiftData.jam_out.substring(0,5) : '00:00');
        
        $('#editShiftModal').data('currentCell', $(this));
        $('#editShiftModal').modal('show');
    });

    // 6. Otomatisasi Jam di Modal Edit
    $('#edit_shift_code').on('change', function() {
        const shiftData = masterShifts[$(this).val()];
        if (shiftData) {
            $('#edit_jam_in').val(shiftData.jam_in.substring(0, 5));
            $('#edit_jam_out').val(shiftData.jam_out.substring(0, 5));
        }
    });

    // 7. Simpan Perubahan Jadwal Harian
    $('#btn-save-shift').on('click', function() {
        const id = $('#edit_jadwal_id').val();
        const data = {
            shift_code: $('#edit_shift_code').val(),
            jam_in: $('#edit_jam_in').val(),
            jam_out: $('#edit_jam_out').val(),
        };

        $.ajax({
            url: `/presensi/jadwal/update/${id}`,
            method: 'PUT',
            data: data,
            success: function(response) {
                const cell = $('#editShiftModal').data('currentCell');
                cell.text(response.updated_jadwal.shift_code);
                cell.data('shift-code', response.updated_jadwal.shift_code);
                cell.css('background-color', '#d4edda').animate({backgroundColor: ''}, 2000);
                $('#editShiftModal').modal('hide');
            },
            error: () => Swal.fire('Error', 'Gagal memperbarui shift.', 'error')
        });
    });

    // 8. Hapus Jadwal Satu Karyawan
    $('#schedule-container').on('click', '.btn-delete-schedule', function() {
        const employeeId = $(this).data('employee-id');
        const employeeName = $(this).data('employee-name');
        const periode = $('#periode').val();

        Swal.fire({
            title: 'Hapus Seluruh Jadwal?',
            html: `Anda akan menghapus semua jadwal untuk <strong>${employeeName}</strong> pada periode <strong>${periode}</strong>.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus semua!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#e74a3b',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("jadwal.destroy") }}',
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        periode: periode,
                        employee_id: employeeId
                    },
                    success: function(response) {
                        Swal.fire('Terhapus!', response.success, 'success');
                        $('#btn-tampilkan').click(); // Refresh tabel
                    },
                    error: (xhr) => Swal.fire('Gagal!', xhr.responseJSON.message || 'Gagal menghapus jadwal.', 'error')
                });
            }
        });
    });

    
});
</script>
@endpush
