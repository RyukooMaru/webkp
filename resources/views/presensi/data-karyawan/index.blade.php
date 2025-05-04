@extends('layouts.admin')

@section('main-content')
<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Data Karyawan</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('data-karyawan.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-100">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Data</span>
            </a>
            <div class="table-responsive mt-3">
                <table class="table table-bordered display my-4" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>emp_Code</th>
                            <th>emp_NID</th>
                            <th>emp_Name</th>
                            <th>emp_ActiveYN</th>
                            <th>emp_Address</th>
                            <th>emp_CityCode</th>
                            <th>emp_ProvinceCode</th>
                            <th>emp_DivCode</th>
                            <th>EMP_SUBDIVCODE</th>
                            <th>emp_PosCode</th>
                            <th>emp_ZipCode</th>
                            <th>emp_Phone1</th>
                            <th>emp_Phone2</th>
                            <th>emp_hp1</th>
                            <th>emp_hp2</th>
                            <th>emp_Address2</th>
                            <th>emp_CityCode2</th>
                            <th>emp_ProvinceCode2</th>
                            <th>emp_ZipCode2</th>
                            <th>emp_Phone3</th>
                            <th>emp_Phone4</th>
                            <th>emp_hp3</th>
                            <th>emp_hp4</th>
                            <th>emp_Email</th>
                            <th>emp_Email2</th>
                            <th>emp_Web</th>
                            <th>emp_Sex</th>
                            <th>emp_Marital</th>
                            <th>emp_Religion</th>
                            <th>emp_PlaceBorn</th>
                            <th>emp_DateBorn</th>
                            <th>emp_Enroll</th>
                            <th>emp_startcontract</th>
                            <th>emp_Expired</th>
                            <th>emp_permanent</th>
                            <th>emp_quit</th>
                            <th>emp_reason</th>
                            <th>emp_office</th>
                            <th>emp_ptkp</th>
                            <th>emp_blood</th>
                            <th>EMP_SHIF</th>
                            <th>EMP_PAJAK</th>
                            <th>EMP_status</th>
                            <th>emp_bayar</th>
                            <th>emp_BANK</th>
                            <th>emp_NOREK</th>
                            <th>emp_PEMILIK</th>
                            <th>emp_NPWP</th>
                            <th>emp_education</th>
                            <th>EMP_JAMSOSTEK</th>
                            <th>emp_datejamsostek</th>
                            <th>emp_ktp</th>
                            <th>emp_no_ktp</th>
                            <th>EMP_PICT</th>
                            <th>emp_ENTRYID</th>
                            <th>emp_FirstEntry</th>
                            <th>emp_UpdateID</th>
                            <th>emp_LastUpdate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>emp_Code</th>
                            <th>emp_NID</th>
                            <th>emp_Name</th>
                            <th>emp_ActiveYN</th>
                            <th>emp_Address</th>
                            <th>emp_CityCode</th>
                            <th>emp_ProvinceCode</th>
                            <th>emp_DivCode</th>
                            <th>EMP_SUBDIVCODE</th>
                            <th>emp_PosCode</th>
                            <th>emp_ZipCode</th>
                            <th>emp_Phone1</th>
                            <th>emp_Phone2</th>
                            <th>emp_hp1</th>
                            <th>emp_hp2</th>
                            <th>emp_Address2</th>
                            <th>emp_CityCode2</th>
                            <th>emp_ProvinceCode2</th>
                            <th>emp_ZipCode2</th>
                            <th>emp_Phone3</th>
                            <th>emp_Phone4</th>
                            <th>emp_hp3</th>
                            <th>emp_hp4</th>
                            <th>emp_Email</th>
                            <th>emp_Email2</th>
                            <th>emp_Web</th>
                            <th>emp_Sex</th>
                            <th>emp_Marital</th>
                            <th>emp_Religion</th>
                            <th>emp_PlaceBorn</th>
                            <th>emp_DateBorn</th>
                            <th>emp_Enroll</th>
                            <th>emp_startcontract</th>
                            <th>emp_Expired</th>
                            <th>emp_permanent</th>
                            <th>emp_quit</th>
                            <th>emp_reason</th>
                            <th>emp_office</th>
                            <th>emp_ptkp</th>
                            <th>emp_blood</th>
                            <th>EMP_SHIF</th>
                            <th>EMP_PAJAK</th>
                            <th>EMP_status</th>
                            <th>emp_bayar</th>
                            <th>emp_BANK</th>
                            <th>emp_NOREK</th>
                            <th>emp_PEMILIK</th>
                            <th>emp_NPWP</th>
                            <th>emp_education</th>
                            <th>EMP_JAMSOSTEK</th>
                            <th>emp_datejamsostek</th>
                            <th>emp_ktp</th>
                            <th>emp_no_ktp</th>
                            <th>EMP_PICT</th>
                            <th>emp_ENTRYID</th>
                            <th>emp_FirstEntry</th>
                            <th>emp_UpdateID</th>
                            <th>emp_LastUpdate</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($Employees as $index => $Employee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $Employee->emp_Code }} </td>
                            <td>{{ $Employee->emp_NID }} </td>
                            <td>{{ $Employee->emp_Name }} </td>
                            <td>{{ $Employee->emp_ActiveYN }} </td>
                            <td>{{ $Employee->emp_Address }} </td>
                            <td>{{ $Employee->emp_CityCode }} </td>
                            <td>{{ $Employee->emp_ProvinceCode }} </td>
                            <td>{{ $Employee->emp_DivCode }} </td>
                            <td>{{ $Employee->EMP_SUBDIVCODE }} </td>
                            <td>{{ $Employee->emp_PosCode }} </td>
                            <td>{{ $Employee->emp_ZipCode }} </td>
                            <td>{{ $Employee->emp_Phone1 }} </td>
                            <td>{{ $Employee->emp_Phone2 }} </td>
                            <td>{{ $Employee->emp_hp1 }} </td>
                            <td>{{ $Employee->emp_hp2 }} </td>
                            <td>{{ $Employee->emp_Address2 }} </td>
                            <td>{{ $Employee->emp_CityCode2 }} </td>
                            <td>{{ $Employee->emp_ProvinceCode2 }} </td>
                            <td>{{ $Employee->emp_ZipCode2 }} </td>
                            <td>{{ $Employee->emp_Phone3 }} </td>
                            <td>{{ $Employee->emp_Phone4 }} </td>
                            <td>{{ $Employee->emp_hp3 }} </td>
                            <td>{{ $Employee->emp_hp4 }} </td>
                            <td>{{ $Employee->emp_Email }} </td>
                            <td>{{ $Employee->emp_Email2 }} </td>
                            <td>{{ $Employee->emp_Web }} </td>
                            <td>{{ $Employee->emp_Sex }} </td>
                            <td>{{ $Employee->emp_Marital }} </td>
                            <td>{{ $Employee->emp_Religion }} </td>
                            <td>{{ $Employee->emp_PlaceBorn }} </td>
                            <td>{{ $Employee->emp_DateBorn }} </td>
                            <td>{{ $Employee->emp_Enroll }} </td>
                            <td>{{ $Employee->emp_startcontract }} </td>
                            <td>{{ $Employee->emp_Expired }} </td>
                            <td>{{ $Employee->emp_permanent }} </td>
                            <td>{{ $Employee->emp_quit }} </td>
                            <td>{{ $Employee->emp_reason }} </td>
                            <td>{{ $Employee->emp_office }} </td>
                            <td>{{ $Employee->emp_ptkp }} </td>
                            <td>{{ $Employee->emp_blood }} </td>
                            <td>{{ $Employee->EMP_SHIF }} </td>
                            <td>{{ $Employee->EMP_PAJAK }} </td>
                            <td>{{ $Employee->EMP_status }} </td>
                            <td>{{ $Employee->emp_bayar }} </td>
                            <td>{{ $Employee->emp_BANK }} </td>
                            <td>{{ $Employee->emp_NOREK }} </td>
                            <td>{{ $Employee->emp_PEMILIK }} </td>
                            <td>{{ $Employee->emp_NPWP }} </td>
                            <td>{{ $Employee->emp_education }} </td>
                            <td>{{ $Employee->EMP_JAMSOSTEK }} </td>
                            <td>{{ $Employee->emp_datejamsostek }} </td>
                            <td>{{ $Employee->emp_ktp }} </td>
                            <td>{{ $Employee->emp_no_ktp }} </td>
                            <td>
                                @if ($Employee->EMP_PICT)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($Employee->EMP_PICT) }}" alt="Employee Picture" width="100" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td>{{ $Employee->emp_ENTRYID }} </td>
                            <td>{{ \Carbon\Carbon::parse($Employee->emp_FirstEntry)->format('d-m-Y H:i') }}</td>
                            <td>{{ $Employee->emp_UpdateID }} </td>
                            <td>{{ $Employee->emp_LastUpdate }} </td>
                            <td>
                                <a href="{{ route('data-karyawan.edit', $Employee->emp_Auto)}}" class="mb-2 btn btn-sm btn-warning edit-btn shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn delete-empbtn shadow-sm" 
                                    data-url="{{ route('data-karyawan.destroy', $Employee) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($Employees) > 0)
            <!-- Tampilkan tabel -->
            @else
                <div class="alert alert-info">Tidak ada Data Karyawan tersedia.</div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteEMPModal" tabindex="-1" aria-labelledby="confirmDeleteEMPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteEMPModalLabel">Konfirmasi Penghapusan Data Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteEMPForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" >Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteEmployeeButtons = document.querySelectorAll('.delete-empbtn');
        const deleteEmployeeForm = document.getElementById('deleteEMPForm');
        const modalEmployee = new bootstrap.Modal(document.getElementById('confirmDeleteEMPModal'));

        deleteEmployeeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                deleteEmployeeForm.setAttribute('action', url);
                modalEmployee.show();
            });
        });
    });
</script>
@endsection
