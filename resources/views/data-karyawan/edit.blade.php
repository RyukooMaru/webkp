@extends('layouts.admin')

@section('main-content')
<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Page Heading -->
    <a href="{{ route('data-karyawan.index') }}" class="btn btn-light mb-3">
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span class="h5 text mt-6 mb-4 text-gray-800">Kembali</span>
    </a>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Divisi</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('data-karyawan.update', $ts_div->div_auto) }}">
                @csrf
                @method('PUT')
                <div>
                    <div>
                        <label for="Div_Code">Code Divisi:</label>
                    </div>
                    <input type="text" name="Div_Code" id="Div_Code" value="{{ $ts_div->Div_Code }}" class="form-control bg-light border-0 small">
                    <div>
                        <label for="Div_Name">Nama Divisi:</label>
                    </div>
                    <input type="text" name="Div_Name" id="Div_Name" value="{{ $ts_div->Div_Name }}" class="form-control bg-light border-0 small">
                    <div>
                        <label for="DIV_NIK">NIK:</label>
                    </div>
                    <input type="text" name="DIV_NIK" id="DIV_NIK" value="{{ $ts_div->DIV_NIK }}" class="form-control bg-light border-0 small">
                    <div>
                        <label for="DIV_SHIFTYN">Shift:</label>
                    </div>
                    <input type="text" name="DIV_SHIFTYN" id="DIV_SHIFTYN" value="{{ $ts_div->DIV_SHIFTYN }}" class="form-control bg-light border-0 small">
                    <div>
                        <label for="DIV_BIAYA">Biaya:</label>
                    </div>
                    <input type="text" name="DIV_BIAYA" id="DIV_BIAYA" value="{{ $ts_div->DIV_BIAYA }}" class="form-control bg-light border-0 small">
                    <div>
                        <label for="Div_EntryID">Entry:</label>
                    </div>
                    <input type="text" name="Div_EntryID" id="Div_EntryID" value="{{ $ts_div->Div_EntryID }}" class="form-control bg-light border-0 small">
                    <div>
                        <label for="Div_Entrydate">Entry Date:</label>
                    </div>
                    <input type="date" name="Div_Entrydate" id="Div_Entrydate" value="{{ $ts_div->Div_Entrydate }}" class="form-control bg-light border-0 small">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary shadow-sm mt-3">
                        <span class="text">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
