@extends('layouts.template-body')
@section('content')
<script>
window.productsData = {!! $productsJson !!};
window.routeProductsUpdate = @json(route('product.update', ['id' => 'PRODUCT_ID']));
</script>
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
<div class="container px-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-semibold mb-4 mt-4">Produk Saya</h3>
            </div>
            <div class="row" id="products-creator">
                @foreach($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                        @include('products.card-product', ['product' => $product, 'product_id' => $product->id])
                    </div>
                @endforeach
                <!-- Tambah Produk Card -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-primary border-2 card-karyas inner-card-dark rounded-xsmall d-flex align-items-center justify-content-center" style="cursor:pointer; min-height: 250px;" data-bs-toggle="modal" data-bs-target="#modalFormProduk" title="Tambah Produk Baru">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <span style="font-size:3rem; color:#c9aaff;">+</span>
                            <p class="text-primary pt-2 fw-bold" style="font-size:1.2rem;">Tambah Produk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pilih Jenis Produk -->
    <div class="modal fade" id="modalJenisProduk" tabindex="-1" aria-labelledby="modalJenisProdukLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalJenisProdukLabel">Pilih Jenis Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3 justify-content-center">
              <div class="col-md-3 col-6">
                <a href="{{ route('products.create', ['type' => 'buku']) }}" class="text-decoration-none">
                  <div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark text-white text-center p-3" style="cursor:pointer; min-height: 180px;">
                    <div style="font-size:2.2rem;">📚</div>
                    <div class="fw-bold mb-1 mt-2"><span class="badge bg-info text-dark px-3 py-2">Buku</span></div>
                    <div class="small">Produk fisik, dikirim ke alamat pembeli.</div>
            </div>
                </a>
              </div>
              <div class="col-md-3 col-6">
                <a href="{{ route('products.create', ['type' => 'ebook']) }}" class="text-decoration-none">
                  <div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark text-white text-center p-3" style="cursor:pointer; min-height: 180px;">
                    <div style="font-size:2.2rem;">📄</div>
                    <div class="fw-bold mb-1 mt-2"><span class="badge bg-success text-white px-3 py-2">Ebook</span></div>
                    <div class="small">File digital (PDF, ePub, dll).</div>
              </div>
                </a>
              </div>
              <div class="col-md-3 col-6">
                <a href="{{ route('products.create', ['type' => 'ecourse']) }}" class="text-decoration-none">
                  <div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark text-white text-center p-3" style="cursor:pointer; min-height: 180px;">
                    <div style="font-size:2.2rem;">🎥</div>
                    <div class="fw-bold mb-1 mt-2"><span class="badge bg-primary text-white px-3 py-2">Ecourse</span></div>
                    <div class="small">Kursus video/online, akses digital.</div>
              </div>
                </a>
              </div>
              <div class="col-md-3 col-6">
                <a href="{{ route('products.create', ['type' => 'digital']) }}" class="text-decoration-none">
                  <div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark text-white text-center p-3" style="cursor:pointer; min-height: 180px;">
                    <div style="font-size:2.2rem;">💾</div>
                    <div class="fw-bold mb-1 mt-2"><span class="badge bg-warning text-dark px-3 py-2">Digital</span></div>
                    <div class="small">Produk digital lain (template, software, dsb).</div>
              </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Form Produk -->
    @include('products.modal-form')
    @include('products.modal-edit')
</div>
@endsection 