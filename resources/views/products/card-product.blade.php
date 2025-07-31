@php
$type = $product->type ?? 'buku';
$typeLabel = [
    'buku' => 'Buku',
    'ebook' => 'Ebook',
    'ecourse' => 'Ecourse',
    'digital' => 'Digital',
][$type] ?? ucfirst($type);
$badgeColor = [
    'buku' => 'bg-info text-dark',
    'ebook' => 'bg-success text-white',
    'ecourse' => 'bg-primary text-white',
    'digital' => 'bg-warning text-dark',
][$type] ?? 'bg-secondary text-dark';
$isFree = (isset($product->price) && $product->price == 0);
$showActions = isset($showActions) ? $showActions : true;
@endphp
<div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark product-card" style="cursor: pointer; transition: all 0.3s ease; min-height: 280px;" onclick="window.location.href='{{ route('products.show', $product->id) }}'" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
    <div class="img-list-content position-relative">
        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}" class="img-fluid card-header-bg product-image" alt="Product image" style="border-radius: 12px 12px 0 0; height: 160px; object-fit: cover; width: 100%;">
        <span class="position-absolute" style="top:8px; right:8px; z-index:2;">
            <span class="badge {{ $badgeColor }} text-capitalize product-badge" style="font-size:0.8em; padding:4px 12px; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,0.08); letter-spacing:0.5px;">{{ $typeLabel }}</span>
        </span>
    </div>
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between gap-2 content-title flex-grow-1">
            <div class="d-flex flex-column w-100">
                <p class="text-line-2 m-0 product-title">{{ $product->name }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent border-0">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted w-50 text-line-1 product-location">
                @if($type === 'buku')
                    <i class="ri-map-pin-line"></i> {{ $product->buku->city ?? '-' }}
                @else
                    &nbsp;
                @endif
            </span>
            <span class="text-muted text-line-1 product-price">
                @if($isFree)
                    <span class="badge bg-warning text-dark">Free</span>
                @else
                    <span class="badge bg-success text-white">Rp{{ number_format($product->price,0,',','.') }}</span>
                @endif
            </span>
        </div>
    </div>
</div>
{{-- Tombol Edit & Hapus hanya jika showActions true --}}
@if($showActions)
<div class="d-flex gap-2 mt-2 mb-4" onclick="event.stopPropagation();">
    <a href="{{ url('product/manage/'.$product_id.'/edit') }}" class="btn btn-warning fw-bold w-50" style="border-radius: 8px;">
        <i class="ri-edit-line"></i> Edit
    </a>
    @if(auth()->check() && auth()->user()->hasRole('creator'))
        <form action="{{ route('products.destroy', $product_id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')" class="w-50">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger fw-bold w-100" style="border-radius: 8px;"><i class="ri-delete-bin-6-line"></i> Hapus</button>
        </form>
    @endif
</div>
@endif 