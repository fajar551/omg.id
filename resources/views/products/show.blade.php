@extends('layouts.template-body')

@section('content')
<div class="container px-5 mb-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}" class="text-decoration-none">Daftar Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 rounded-small inner-card-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}" 
                                         class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 400px; object-fit: cover;">
                                </div>
                                <div class="col-md-6">
                                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
                                    
                                    @php
                                        $typeLabel = [
                                            'buku' => 'Buku',
                                            'ebook' => 'Ebook',
                                            'ecourse' => 'Ecourse',
                                            'digital' => 'Digital',
                                        ][$product->type] ?? ucfirst($product->type);
                                        
                                        $badgeColor = [
                                            'buku' => 'bg-info text-dark',
                                            'ebook' => 'bg-success text-white',
                                            'ecourse' => 'bg-primary text-white',
                                            'digital' => 'bg-warning text-dark',
                                        ][$product->type] ?? 'bg-secondary text-dark';
                                    @endphp
                                    
                                    <span class="badge {{ $badgeColor }} mb-3" style="font-size: 1em; padding: 8px 16px;">
                                        {{ $typeLabel }}
                                    </span>
                                    
                                    <div class="mb-3">
                                        <h4 class="text-primary fw-bold">
                                            @if($product->price == 0)
                                                <span class="badge bg-warning text-dark">Free</span>
                                            @else
                                                Rp{{ number_format($product->price, 0, ',', '.') }}
                                            @endif
                                        </h4>
                                    </div>
                                    
                                    @if($product->description)
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">Deskripsi:</h6>
                                            <p class="text-muted">{{ $product->description }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($product->type === 'buku' && $product->buku)
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">Lokasi:</h6>
                                            <p class="text-muted">
                                                <i class="ri-map-pin-line"></i> {{ $product->buku->city ?? '-' }}
                                            </p>
                                        </div>
                                        
                                        @if($product->stock !== null)
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Stok:</h6>
                                                <p class="text-muted">{{ $product->stock }} unit</p>
                                            </div>
                                        @endif
                                    @endif
                                    
                                    @if($product->type === 'ebook' && $product->ebook)
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">Jumlah Halaman:</h6>
                                            <p class="text-muted">{{ $product->ebook->ebook_pages ?? '-' }} halaman</p>
                                        </div>
                                    @endif
                                    
                                    @if($product->type === 'ecourse' && $product->ecourse)
                                        <div class="mb-3">
                                            <h6 class="fw-semibold">Durasi:</h6>
                                            <p class="text-muted">{{ $product->ecourse->ecourse_duration ?? '-' }} menit</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 rounded-small inner-card-dark">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">Navigasi</h5>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                    <i class="ri-arrow-left-line"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 