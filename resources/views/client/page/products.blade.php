@extends('layouts.template-body')

@section('title')
    <title>Produk Saya</title>
@endsection

@section('content')
<div class="container px-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card creators border-0 mb-md-4 mt-md-4 p-4 card-dark">
                <h5 class="fw-semibold">Produk Saya</h5>
                <div class="row" id="products-creator">
                    @foreach ($products['data'] as $product)
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                        @include('components.card-content-v2', [
                            'content' => [
                                'title' => $product['name'],
                                'description' => $product['description'],
                                'thumbnail_path' => $product['image'] ? asset('storage/' . $product['image']) : asset('assets/img/image.png'),
                                'price' => $product['price'],
                                'stock' => $product['stock'],
                            ],
                        ])
                    </div>
                    @endforeach
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                        <div class="card card-karyas rounded-xsmall border-primary shadow-sm rounded-small inner-card-dark" onclick="$('#modalTambahProduk').modal('show')" title="Tambah Produk Baru">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('template/images/icon/pluss.svg') }}" alt="" class="pluss mt-2">
                                <p class="text-primary pt-2">Tambah Produk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahProdukLabel">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="row">
                <div class="col-md-8 order-md-1 order-2">
                  <div class="card shadow border-0 rounded-small min-vh-50 card-dark">
                    <div class="card-body">
                      <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="type" class="form-label">Jenis Produk <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                          <option value="">Pilih Jenis Produk</option>
                          <option value="ebook">Ebook</option>
                          <option value="ecourse">Ecourse</option>
                          <option value="buku">Buku Fisik</option>
                          <option value="digital">Digital Product</option>
                        </select>
                        @error('type')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3" id="form-stock">
                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" min="0">
                        @error('stock')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
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
                        <img class="img-thumbnail rounded icon-160" id="enlarge-img" src="{{ asset('assets/img/image.png') }}" alt="Preview Gambar">
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
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<script>
// Wait for jQuery to be available
function initializeProductFormScripts() {
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, retrying in 100ms...');
        setTimeout(initializeProductFormScripts, 100);
        return;
    }
    
    console.log('jQuery is available, initializing product form scripts...');
    
    $(document).ready(function() {
        const typeSelect = document.getElementById('type');
        const stockField = document.getElementById('form-stock');
        
        function toggleStockField() {
            const selectedType = typeSelect.value;
            if (stockField) {
                // Sembunyikan stok jika digital, ebook, atau ecourse
                stockField.style.display = (selectedType === 'digital' || selectedType === 'ebook' || selectedType === 'ecourse') ? 'none' : 'block';
                
                // Set required attribute based on type
                const stockInput = document.getElementById('stock');
                if (stockInput) {
                    stockInput.required = (selectedType === 'buku');
                }
            }
        }
        
        if (typeSelect) {
            typeSelect.addEventListener('change', toggleStockField);
            // Initial call
            toggleStockField();
        }
    });
}

// Initialize scripts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeProductFormScripts();
});

// Also try to initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeProductFormScripts);
} else {
    initializeProductFormScripts();
}
</script>
@endsection 