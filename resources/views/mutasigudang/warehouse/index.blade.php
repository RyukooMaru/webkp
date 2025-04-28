@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Daftar Gudang</h1>
    <a href="{{ route('warehouse.create') }}" class="btn btn-primary mb-3">Tambah Gudang</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Fax</th>
                <th>Email</th>
                <th>Web</th>
                <th>Catatan 1</th>
                <th>Catatan 2</th>
                <th>Pengguna</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($warehouses as $index => $warehouse)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $warehouse->WARE_Name }}</td>
                <td>{{ $warehouse->WARE_Address }}</td>
                <td>{{ $warehouse->WARE_Phone }}</td>
                <td>{{ $warehouse->WARE_Fax }}</td>
                <td>{{ $warehouse->WARE_Email }}</td>
                <td>{{ $warehouse->WARE_Web }}</td>
                <td>{{ $warehouse->ware_note1 }}</td>
                <td>{{ $warehouse->ware_note2 }}</td>
                <td>{{ auth()->user()->name ?? '-' }}</td> <!-- Atau ganti dengan field pengguna -->
                <td>{{ $warehouse->WARE_EntryDate ? \Carbon\Carbon::parse($warehouse->WARE_EntryDate)->format('d F Y') : '' }}</td>
                <td>
                    <a href="{{ route('warehouse.edit', $warehouse->WARE_Auto) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('warehouse.destroy', $warehouse->WARE_Auto) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
