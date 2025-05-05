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

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Content Row -->
    
    <!-- Card Row -->
    <form method="POST" class="needs-validation" action="{{ route('data-karyawan.update', $Employee->emp_Auto) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Karyawan</h6>
                    </div>
                    <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Code">Kode Karyawan:</label>
                                            <input type="text" name="emp_Code" id="emp_Code" value="{{ $Employee->emp_Code }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_NID">Nomor Induk Karyawan:</label>
                                            <input type="text" name="emp_NID" id="emp_NID" value="{{ $Employee->emp_NID }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Name">Nama Karyawan:</label>
                                            <input type="text" name="emp_Name" id="emp_Name" value="{{ $Employee->emp_Name }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_ActiveYN">Aktif? (Y/N):</label>
                                            <select name="emp_ActiveYN" id="emp_ActiveYN" class="form-control bg-light small">
                                                <!-- <option selected disabled value=>Choose...</option> -->
                                                <option value="" {{ $Employee->emp_Sex == '' ? 'selected' : '' }}>Pilih</option>
                                                <option value="Y" {{ $Employee->emp_Sex == 'Y' ? 'selected' : '' }}>Ya</option>
                                                <option value="N" {{ $Employee->emp_Sex == 'N' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_DivCode">Divisi Code:</label>
                                            <input type="text" name="emp_DivCode" id="emp_DivCode" value="{{ $Employee->emp_DivCode }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="EMP_SUBDIVCODE">Sub-Divisi Code:</label>
                                            <input type="text" name="EMP_SUBDIVCODE" id="EMP_SUBDIVCODE" value="{{ $Employee->EMP_SUBDIVCODE }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_PosCode">Posisi Code:</label>
                                            <input type="text" name="emp_PosCode" id="emp_PosCode" value="{{ $Employee->emp_PosCode }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Email">Email 1:</label>
                                            <input type="text" name="emp_Email" id="emp_Email" value="{{ $Employee->emp_Email }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Email2">Email 2:</label>
                                            <input type="text" name="emp_Email2" id="emp_Email2" value="{{ $Employee->emp_Email2 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Web">Website:</label>
                                            <input type="text" name="emp_Web" id="emp_Web" value="{{ $Employee->emp_Web }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Sex">Jenis Kelamin:</label>
                                            <select name="emp_Sex" id="emp_Sex" class="form-control bg-light small">
                                                <!-- <option selected disabled value=>Choose...</option> -->
                                                <option value="" {{ $Employee->emp_Sex == '' ? 'selected' : '' }}>Pilih</option>
                                                <option value="M" {{ $Employee->emp_Sex == 'M' ? 'selected' : '' }}>Pria</option>
                                                <option value="F" {{ $Employee->emp_Sex == 'F' ? 'selected' : '' }}>Wanita</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Marital">Status Kawin:</label>
                                            <select name="emp_Marital" id="emp_Marital" class="form-control bg-light small">
                                                <!-- <option selected disabled value=>Choose...</option> -->
                                                <option value="" {{ $Employee->emp_Marital == '' ? 'selected' : '' }}>Pilih</option>
                                                <option value="S" {{ $Employee->emp_Marital == 'S' ? 'selected' : '' }}>Lajang</option>
                                                <option value="M" {{ $Employee->emp_Marital == 'M' ? 'selected' : '' }}>Menikah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Religion">Agama:</label>
                                            <input type="text" name="emp_Religion" id="emp_Religion" value="{{ $Employee->emp_Religion }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_PlaceBorn">Tempat Lahir:</label>
                                            <input type="text" name="emp_PlaceBorn" id="emp_PlaceBorn" value="{{ $Employee->emp_PlaceBorn }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_DateBorn">Tanggal Lahir:</label>
                                            <input type="date" name="emp_DateBorn" id="emp_DateBorn" value="{{ $Employee->emp_DateBorn }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_blood">Golongan Darah:</label>
                                            <select name="emp_blood" id="emp_blood" class="form-control bg-light small">
                                                <!-- <option selected disabled value=>Choose...</option> -->
                                                <option value="" {{ $Employee->emp_blood == '' ? 'selected' : '' }}>Pilih</option>
                                                <option value="O" {{ $Employee->emp_blood == 'O' ? 'selected' : '' }}>O</option>
                                                <option value="A" {{ $Employee->emp_blood == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ $Employee->emp_blood == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="AB" {{ $Employee->emp_blood == 'AB' ? 'selected' : '' }}>AB</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_education">Pendidikan terakhir:</label>
                                            <input type="text" name="emp_education" id="emp_education" value="{{ $Employee->emp_education }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <div class="card-profile-image mt-4">
                            <figure class="rounded-circle mb-4" 
                                style="height: 180px; width: 180px; margin: auto; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f0f0f0;">
                                <img id="preview" 
                                    style="width: 100%; height: 100%; object-fit: cover;" src="data:image/jpeg;base64,{{ base64_encode($Employee->EMP_PICT) }}">
                            </figure>
                        </div>
                        <input type="hidden" name="hapus_gambar" id="hapus_gambar" value="0">
                        <div class="text-center my-4">
                            <button type="button" id="removeImageBtn" class="btn btn-sm btn-danger">Hapus Foto</button>
                        </div>
                        <h5 class="text-center">Foto Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="EMP_PICT" class="text-center">Upload Foto Karyawan (EMP_PICT)</label>
                            <input type="file" name="EMP_PICT" id="EMP_PICT" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Row -->
        <div class="row">
            <div class="col-lg-6 order-lg-1">
                <div class="card shadow mb-4">
                    <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Address">Alamat:</label>
                                            <textarea type="text" name="emp_Address" id="emp_Address" placeholder="{{ $Employee->emp_Address }}" class="form-control bg-light small"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_CityCode">Kode Kota:</label>
                                            <input type="text" name="emp_CityCode" id="emp_CityCode" value="{{ $Employee->emp_CityCode }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_ProvinceCode">Kode Provinsi:</label>
                                            <input type="text" name="emp_ProvinceCode" id="emp_ProvinceCode" value="{{ $Employee->emp_ProvinceCode }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_ZipCode">Zip Code:</label>
                                            <input type="text" name="emp_ZipCode" id="emp_ZipCode" value="{{ $Employee->emp_ZipCode }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Phone1">No. Telpon 1:</label>
                                            <input type="text" name="emp_Phone1" id="emp_Phone1" value="{{ $Employee->emp_Phone1 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Phone2">No. Telpon 2:</label>
                                            <input type="text" name="emp_Phone2" id="emp_Phone2" value="{{ $Employee->emp_Phone2 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_hp1">No. Handphone 1:</label>
                                            <input type="text" name="emp_hp1" id="emp_hp1" value="{{ $Employee->emp_hp1 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_hp2">No. Handphone 2:</label>
                                            <input type="text" name="emp_hp2" id="emp_hp2" value="{{ $Employee->emp_hp2 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2">
                <div class="card shadow mb-4">
                    <div class="card-body">
                            <div class="pl-lg-2">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Address2">Alamat 2:</label>
                                            <textarea type="text" name="emp_Address2" id="emp_Address2" placeholder="{{ $Employee->emp_Address2 }}" class="form-control bg-light small"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_CityCode2">Kode Kota 2:</label>
                                            <input type="text" name="emp_CityCode2" id="emp_CityCode2" value="{{ $Employee->emp_CityCode2 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_ProvinceCode2">Kode Provinsi 2:</label>
                                            <input type="text" name="emp_ProvinceCode2" id="emp_ProvinceCode2" value="{{ $Employee->emp_ProvinceCode2 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_ZipCode2">Zip Code 2:</label>
                                            <input type="text" name="emp_ZipCode2" id="emp_ZipCode2" value="{{ $Employee->emp_ZipCode2 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Phone3">No. Telpon 3:</label>
                                            <input type="text" name="emp_Phone3" id="emp_Phone3" value="{{ $Employee->emp_Phone3 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_Phone4">No. Telpon 4:</label>
                                            <input type="text" name="emp_Phone4" id="emp_Phone4" value="{{ $Employee->emp_Phone4 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_hp3">No. Handphone 3:</label>
                                            <input type="text" name="emp_hp3" id="emp_hp3" value="{{ $Employee->emp_hp3 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="emp_hp4">No. Handphone 4:</label>
                                            <input type="text" name="emp_hp4" id="emp_hp4" value="{{ $Employee->emp_hp4 }}" class="form-control bg-light small">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                    <div class="pl-lg-2">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_Enroll">Tanggal Enroll:</label>
                                    <input type="date" name="emp_Enroll" id="emp_Enroll" value="{{ $Employee->emp_Enroll }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_startcontract">Tanggal Mulai Contract:</label>
                                    <input type="date" name="emp_startcontract" id="emp_startcontract" value="{{ $Employee->emp_startcontract }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_Expired">Tanggal Contract Expired:</label>
                                    <input type="date" name="emp_Expired" id="emp_Expired" value="{{ $Employee->emp_Expired }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_permanent">Tanggal Permanent:</label>
                                    <input type="date" name="emp_permanent" id="emp_permanent" value="{{ $Employee->emp_permanent }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_quit">Tanggal Quit:</label>
                                    <input type="date" name="emp_quit" id="emp_quit" value="{{ $Employee->emp_quit }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_reason">Code Alasan:</label>
                                    <input type="text" name="emp_reason" id="emp_reason" value="{{ $Employee->emp_reason }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_office">Office:</label>
                                    <input type="text" name="emp_office" id="emp_office" value="{{ $Employee->emp_office }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="EMP_SHIF">Shift Code:</label>
                                    <input type="text" name="EMP_SHIF" id="EMP_SHIF" value="{{ $Employee->EMP_SHIF }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="EMP_status">Status:</label>
                                    <input type="text" name="EMP_status" id="EMP_status" value="{{ $Employee->EMP_status }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_ptkp">Status PTKP:</label>
                                    <input type="text" name="emp_ptkp" id="emp_ptkp" value="{{ $Employee->emp_ptkp }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label class="form-control-label" for="EMP_PAJAK">Pajak:</label>
                                    <input type="text" name="EMP_PAJAK" id="EMP_PAJAK" value="{{ $Employee->EMP_PAJAK }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_bayar">Pembayaran:</label>
                                    <input type="text" name="emp_bayar" id="emp_bayar" value="{{ $Employee->emp_bayar }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_BANK">Code Bank:</label>
                                    <input type="text" name="emp_BANK" id="emp_BANK" value="{{ $Employee->emp_BANK }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_NOREK">No.Rekening:</label>
                                    <input type="text" name="emp_NOREK" id="emp_NOREK" value="{{ $Employee->emp_NOREK }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_PEMILIK">Pemilik:</label>
                                    <input type="text" name="emp_PEMILIK" id="emp_PEMILIK" value="{{ $Employee->emp_PEMILIK }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_NPWP">NPWP:</label>
                                    <input type="text" name="emp_NPWP" id="emp_NPWP" value="{{ $Employee->emp_NPWP }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="EMP_JAMSOSTEK">JAMSOSTEK:</label>
                                    <input type="text" name="EMP_JAMSOSTEK" id="EMP_JAMSOSTEK" value="{{ $Employee->EMP_JAMSOSTEK }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_datejamsostek">Terdaftar Jamsostek:</label>
                                    <input type="date" name="emp_datejamsostek" id="emp_datejamsostek" value="{{ $Employee->emp_datejamsostek }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_ktp">KTP:</label>
                                    <input type="text" name="emp_ktp" id="emp_ktp" value="{{ $Employee->emp_ktp }}" class="form-control bg-light small">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="emp_no_ktp">No. KTP:</label>
                                    <input type="text" name="emp_no_ktp" id="emp_no_ktp" value="{{ $Employee->emp_no_ktp }}" class="form-control bg-light small">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-lg-2">
                        <button type="submit" href="{{ route('data-karyawan.edit', $Employee->emp_Auto)}}" class="btn btn-lg shadow-sm btn-primary px-lg float-right">
                            <span class="text">Save</span>
                        </button>
                    </div>
            </div>
        </div>
    </form>
    
</div>
<!-- /.container-fluid -->
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('EMP_PICT').addEventListener('change', function () {
            const fileInput = this;
            const previewImg = document.getElementById('preview');

            const file = fileInput.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '';
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const previewImg = document.getElementById('preview');
        const fileInput = document.getElementById('EMP_PICT');
        const hapusGambar = document.getElementById('hapus_gambar');
        const removeBtn = document.getElementById('removeImageBtn');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
                hapusGambar.value = 0; // Reset penghapusan
            }
        });

        removeBtn.addEventListener('click', function () {
            previewImg.src = '';
            fileInput.value = '';
            hapusGambar.value = 1; // Tandai dihapus
        });
    });
</script>
