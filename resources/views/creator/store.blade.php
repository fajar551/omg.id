@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-auto">
            <img src="{{ $creator->profile_photo_url ?? asset('template/images/default-profile.png') }}" alt="{{ $creator->name }}" class="rounded-circle" width="100" height="100">
        </div>
        <div class="col">
            <h2 class="mb-1">{{ $creator->name }}</h2>
            <div class="text-muted">@{{ $creator->username }}</div>
            <p class="mt-2">{{ $creator->bio ?? '-' }}</p>
        </div>
    </div>
    <h4 class="mb-3">Produk dari {{ $creator->name }}</h4>
    <div class="row g-3">
        @forelse($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text small flex-grow-1">{{ $product->description }}</p>
                    <div class="fw-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    @if($product->type === 'buku' && $product->stock !== null)
                        <div class="text-muted mb-2">Stok: {{ $product->stock }}</div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">Belum ada produk.</div>
        </div>
        @endforelse
    </div>
</div>
@endsection 