@extends('layouts.template-body')
@section('content')
<div class="container px-5 mb-5">
    <h3 class="fw-semibold mb-4">Tambah Produk Ebook</h3>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
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
            <label for="name" class="form-label">Nama Ebook</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" required value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label for="ebook_file" class="form-label">File Ebook (PDF)</label>
            <input type="file" name="ebook_file" id="ebook_file" class="form-control" accept="application/pdf">
        </div>
        <div class="mb-3">
            <label for="ebook_pages" class="form-label">Jumlah Halaman</label>
            <input type="number" name="ebook_pages" id="ebook_pages" class="form-control" value="{{ old('ebook_pages') }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Ebook</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <input type="hidden" name="type" value="ebook">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection 