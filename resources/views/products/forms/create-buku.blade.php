@extends('layouts.template-body')
@section('content')
<div class="container px-5 mb-5">
    <h3 class="fw-semibold mb-4">Tambah Produk Buku</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="ajax-product-form">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Buku</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" required value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">Kota</label>
            <input type="text" name="buku_city" id="city" class="form-control" value="{{ old('buku_city') }}">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control" required value="{{ old('stock') }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Buku</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <input type="hidden" name="type" value="buku">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection 