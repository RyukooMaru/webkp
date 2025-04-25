@extends('layouts.admin')

@section('main-content')
<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center mb-4 justify-content-between">

        <h1 class="h3 mb-0 text-gray-800">Divisi</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Divisi</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('data-karyawan.create') }}" class="btn btn-primary">
                <span class="text">+ Add Data</span>
            </a>
            <div class="table-responsive mt-3">
                <table class="table table-bordered display my-4" id="myTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Shift Y/N</th>
                            <th>Biaya</th>
                            <th>Entry ID</th>
                            <th>Entry Date</th>
                            <th>User ID</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Shift Y/N</th>
                            <th>Biaya</th>
                            <th>Entry ID</th>
                            <th>Entry Date</th>
                            <th>User ID</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($ts_divs as $ts_div)
                        <tr>
                            <td>{{ $ts_div->Div_Code }}</td>
                            <td>{{ $ts_div->Div_Name }}</td>
                            <td>{{ $ts_div->DIV_NIK }}</td>
                            <td>{{ $ts_div->DIV_SHIFTYN }}</td>
                            <td>{{ $ts_div->DIV_BIAYA }}</td>
                            <td>{{ $ts_div->Div_EntryID }}</td>
                            <td>{{ $ts_div->Div_Entrydate }}</td>
                            <td>{{ $ts_div->Div_UserID }}</td>
                            <td>{{ $ts_div->Div_LastUpdate }}</td>
                            <td>
                                <a href="{{ route('data-karyawan.edit', $ts_div->div_auto)}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('data-karyawan.destroy', $ts_div) }}" class="inline">
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
