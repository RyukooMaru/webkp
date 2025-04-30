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
            <a href="{{ route('data-karyawan.create') }}" class="btn btn-primary">
                <span class="text">+ Add Data</span>
            </a>
            <div class="table-responsive mt-3">
                <table class="table table-bordered display my-4" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>emp_Auto</th>
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
                            <th>emp_Auto</th>
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
                        @foreach($m_employees as $m_employee)
                        <tr>
                            <td>{{ $m_employee->emp_Auto }}</td>
                            <td>{{ $m_employee->emp_Code }} </td>
                            <td>{{ $m_employee->emp_NID }} </td>
                            <td>{{ $m_employee->emp_Name }} </td>
                            <td>{{ $m_employee->emp_ActiveYN }} </td>
                            <td>{{ $m_employee->emp_Address }} </td>
                            <td>{{ $m_employee->emp_CityCode }} </td>
                            <td>{{ $m_employee->emp_ProvinceCode }} </td>
                            <td>{{ $m_employee->emp_DivCode }} </td>
                            <td>{{ $m_employee->EMP_SUBDIVCODE }} </td>
                            <td>{{ $m_employee->emp_PosCode }} </td>
                            <td>{{ $m_employee->emp_ZipCode }} </td>
                            <td>{{ $m_employee->emp_Phone1 }} </td>
                            <td>{{ $m_employee->emp_Phone2 }} </td>
                            <td>{{ $m_employee->emp_hp1 }} </td>
                            <td>{{ $m_employee->emp_hp2 }} </td>
                            <td>{{ $m_employee->emp_Address2 }} </td>
                            <td>{{ $m_employee->emp_CityCode2 }} </td>
                            <td>{{ $m_employee->emp_ProvinceCode2 }} </td>
                            <td>{{ $m_employee->emp_ZipCode2 }} </td>
                            <td>{{ $m_employee->emp_Phone3 }} </td>
                            <td>{{ $m_employee->emp_Phone4 }} </td>
                            <td>{{ $m_employee->emp_hp3 }} </td>
                            <td>{{ $m_employee->emp_hp4 }} </td>
                            <td>{{ $m_employee->emp_Email }} </td>
                            <td>{{ $m_employee->emp_Email2 }} </td>
                            <td>{{ $m_employee->emp_Web }} </td>
                            <td>{{ $m_employee->emp_Sex }} </td>
                            <td>{{ $m_employee->emp_Marital }} </td>
                            <td>{{ $m_employee->emp_Religion }} </td>
                            <td>{{ $m_employee->emp_PlaceBorn }} </td>
                            <td>{{ $m_employee->emp_DateBorn }} </td>
                            <td>{{ $m_employee->emp_Enroll }} </td>
                            <td>{{ $m_employee->emp_startcontract }} </td>
                            <td>{{ $m_employee->emp_Expired }} </td>
                            <td>{{ $m_employee->emp_permanent }} </td>
                            <td>{{ $m_employee->emp_quit }} </td>
                            <td>{{ $m_employee->emp_reason }} </td>
                            <td>{{ $m_employee->emp_office }} </td>
                            <td>{{ $m_employee->emp_ptkp }} </td>
                            <td>{{ $m_employee->emp_blood }} </td>
                            <td>{{ $m_employee->EMP_SHIF }} </td>
                            <td>{{ $m_employee->EMP_PAJAK }} </td>
                            <td>{{ $m_employee->EMP_status }} </td>
                            <td>{{ $m_employee->emp_bayar }} </td>
                            <td>{{ $m_employee->emp_BANK }} </td>
                            <td>{{ $m_employee->emp_NOREK }} </td>
                            <td>{{ $m_employee->emp_PEMILIK }} </td>
                            <td>{{ $m_employee->emp_NPWP }} </td>
                            <td>{{ $m_employee->emp_education }} </td>
                            <td>{{ $m_employee->EMP_JAMSOSTEK }} </td>
                            <td>{{ $m_employee->emp_datejamsostek }} </td>
                            <td>{{ $m_employee->emp_ktp }} </td>
                            <td>{{ $m_employee->emp_no_ktp }} </td>
                            <td>
                                @if ($m_employee->EMP_PICT)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($m_employee->EMP_PICT) }}" alt="Employee Picture" width="100" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td>{{ $m_employee->emp_ENTRYID }} </td>
                            <td>{{ \Carbon\Carbon::parse($m_employee->emp_FirstEntry)->format('d-m-Y H:i') }}</td>
                            <td>{{ $m_employee->emp_UpdateID }} </td>
                            <td>{{ $m_employee->emp_LastUpdate }} </td>
                            <td>
                                <a href="{{ route('data-karyawan.edit', $m_employee->emp_Auto)}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('data-karyawan.destroy', $m_employee) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
