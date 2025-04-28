@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h1>Edit Gudang</h1>

    <form action="{{ route('warehouse.update', $warehouse->WARE_Auto) }}" method="POST">
        @csrf
        @method('PUT')
        @include('mutasigudang.warehouse.form')
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
