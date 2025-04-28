@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Tambah Gudang</h1>

    <form action="{{ route('warehouse.store') }}" method="POST">
        @csrf
        @include('mutasigudang.warehouse.form')
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
