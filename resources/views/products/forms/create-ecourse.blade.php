@extends('layouts.template-body')
@section('content')
<div class="container px-5 mb-5">
    <h3 class="fw-semibold mb-4">Tambah Produk Ecourse</h3>
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
            <label for="name" class="form-label">Nama Ecourse</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" required value="{{ old('price') }}">
        </div>
        <div class="mb-3">
            <label for="ecourse_url" class="form-label">Link Ecourse</label>
            <input type="url" name="ecourse_url" id="ecourse_url" class="form-control" value="{{ old('ecourse_url') }}">
        </div>
        <div class="mb-3">
            <label for="ecourse_duration" class="form-label">Durasi (menit)</label>
            <input type="number" name="ecourse_duration" id="ecourse_duration" class="form-control" value="{{ old('ecourse_duration') }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Ecourse</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <input type="hidden" name="type" value="ecourse">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection 