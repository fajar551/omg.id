@extends('layouts.template-body')
@section('content')
<div class="container px-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card creators border-0 mb-md-4 mt-md-4 p-4 card-dark">
                <h3 class="fw-semibold mb-4">Edit Produk</h3>
                @if(session('success'))
                    <div class="alert shadow-sm d-flex align-items-center inner-card-dark border border-primary border-2 rounded-small mt-3 mb-3" style="background:#232323; color:#dabaff; font-weight:600; font-size:1.05rem;">
                        <span class="me-3" style="font-size:1.7rem; color:#c9aaff;"><i class="ri-checkbox-circle-fill"></i></span>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="filter:invert(1);"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert shadow-sm d-flex align-items-center inner-card-dark border border-danger border-2 rounded-small mt-3 mb-3" style="background:#232323; color:#f22635; font-weight:600; font-size:1.05rem;">
                        <span class="me-3" style="font-size:1.7rem; color:#f22635;"><i class="ri-close-circle-fill"></i></span>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="filter:invert(1);"></button>
                    </div>
                @endif
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8 order-md-1 order-2">
                            <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="type" class="form-label">Jenis Produk <span class="text-danger">*</span></label>
                                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="ecourse" {{ old('type', $product->type) == 'ecourse' ? 'selected' : '' }}>Ecourse</option>
                                            <option value="ebook" {{ old('type', $product->type) == 'ebook' ? 'selected' : '' }}>Ebook</option>
                                            <option value="buku" {{ old('type', $product->type) == 'buku' ? 'selected' : '' }}>Buku</option>
                                            <option value="digital" {{ old('type', $product->type) == 'digital' ? 'selected' : '' }}>Digital Product</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3" id="form-stock">
                                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" min="0">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="form-buku" class="type-form" style="display:none">
                                        <div class="form-group mb-3">
                                            <label for="buku_city" class="form-label">Kota</label>
                                            <input type="text" name="buku_city" id="buku_city" class="form-control" value="{{ old('buku_city', $product->buku_city) }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $product->description) }}">
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-md-2 order-1 mb-3">
                            <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                                <div class="card-header border-0 bg-transparent">
                                    <label class="form-label" for="enlarge-img">Gambar Produk</label>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3 d-flex justify-content-center">
                                        <img class="img-thumbnail rounded icon-160" id="enlarge-img" src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}" alt="Preview Gambar">
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" onchange="document.getElementById('enlarge-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                        <small class="">*) jpg, jpeg, png, Max: 2mb</small>
                                        @error('image')
                                            <div class="invalid-feedback text-danger mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function showTypeForm(type) {
    document.querySelectorAll('.type-form').forEach(f => f.style.display = 'none');
    if(type) {
        var form = document.getElementById('form-' + type);
        if(form) form.style.display = 'block';
    }
    // Sembunyikan stok jika digital, ebook, atau ecourse
    var stockField = document.getElementById('form-stock');
    if(stockField) stockField.style.display = (type === 'digital' || type === 'ebook' || type === 'ecourse') ? 'none' : 'block';
}
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    showTypeForm(typeSelect.value);
    typeSelect.addEventListener('change', function() {
        showTypeForm(this.value);
    });
});
</script>
@endsection 