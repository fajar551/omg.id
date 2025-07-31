@extends('layouts.template-support')

@section('title', $product->name)

@section('styles')
<style>
/* Hide header and navigation */
header, .header, #header, .navbar, nav, .navbar-expand-lg, .navbar-brand, .navbar-nav {
    display: none !important;
}

/* Hide any header-related elements */
[class*="header"], [id*="header"], [class*="navbar"], [id*="navbar"] {
    display: none !important;
}

/* Adjust top margin since header is hidden */
.container-fluid {
    margin-top: 0 !important;
    padding-top: 30px !important;
}

/* Ensure main content area is clean */
#main-content {
    padding-top: 0 !important;
}

/* Ensure body has no top padding/margin */
body {
    padding-top: 0 !important;
    margin-top: 0 !important;
}

/* Top back button styling */
.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.product-detail-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    overflow: hidden;
    margin: 20px 0;
}

.product-image-container {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.product-image {
    max-width: 100%;
    max-height: 350px;
    object-fit: contain;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    background: white;
    padding: 20px;
}

.product-badge {
    position: absolute;
    top: 25px;
    right: 25px;
    z-index: 10;
}

.product-info {
    padding: 40px;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    line-height: 1.3;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.product-price {
    font-size: 2.5rem;
    font-weight: 700;
    color: #27ae60;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
}

.product-description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #007bff;
}

.product-meta {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 30px;
    border: 1px solid #e9ecef;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding: 8px 0;
}

.meta-item:last-child {
    margin-bottom: 0;
}

.meta-icon {
    width: 24px;
    margin-right: 12px;
    color: #6c757d;
    font-size: 1.1rem;
}

.meta-label {
    font-weight: 600;
    color: #495057;
    margin-right: 12px;
    min-width: 80px;
}

.meta-value {
    color: #6c757d;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    justify-content: center;
    margin-top: auto;
    padding-top: 30px;
}

.btn-buy {
    padding: 18px 40px;
    font-size: 1.2rem;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    min-width: 200px;
}

.btn-buy:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Stock status styling - Only for physical books */
.stock-available {
    color: #28a745 !important;
    font-weight: 600;
}

.stock-out {
    color: #dc3545 !important;
    font-weight: 600;
}

/* Disable button when out of stock - Only for physical books */
.btn-buy:disabled {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

@media (max-width: 768px) {
    .product-detail-container {
        margin: 10px;
        border-radius: 15px;
    }
    
    .product-image-container {
        min-height: 300px;
        padding: 20px;
    }
    
    .product-image {
        max-height: 250px;
        padding: 15px;
    }
    
    .product-info {
        padding: 25px;
    }
    
    .product-title {
        font-size: 1.8rem;
        margin-bottom: 15px;
    }
    
    .product-price {
        font-size: 2rem;
        margin-bottom: 20px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 15px;
    }
    
    .btn-buy {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .product-price {
        font-size: 1.8rem;
    }
    
    .product-info {
        padding: 20px;
    }
    
    .product-meta {
        padding: 20px;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Back button at top -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary" style="border-radius: 25px; padding: 10px 25px;">
                <i class="ri-arrow-left-line me-2"></i>Kembali
            </a>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="product-detail-container">
                <div class="row g-0">
                    <!-- Product Image -->
                    <div class="col-lg-6">
                        <div class="product-image-container">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-image">
                            
                            <!-- Product Badge -->
                            <div class="product-badge">
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
                                @endphp
                                <span class="badge {{ $badgeColor }} text-capitalize" style="font-size: 1rem; padding: 10px 18px; border-radius: 8px;">
                                    {{ $typeLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="col-lg-6">
                        <div class="product-info">
                            <h1 class="product-title">{{ $product->name }}</h1>
                            
                            <div class="product-price">
                                @if(isset($product->price) && $product->price == 0)
                                    <span class="badge bg-warning text-dark" style="font-size: 1.8rem; padding: 12px 24px; border-radius: 10px;">Gratis</span>
                                @else
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </div>
                            
                            @if($product->description)
                                <div class="product-description">
                                    <strong>Deskripsi:</strong><br>
                                    {{ $product->description }}
                                </div>
                            @endif
                            
                            <!-- Product Meta Information -->
                            <div class="product-meta">
                                <div class="meta-item">
                                    <i class="ri-user-line meta-icon"></i>
                                    <span class="meta-label">Creator:</span>
                                    <span class="meta-value">{{ $pageName ?? 'Unknown' }}</span>
                                </div>
                                
                                @if($type === 'buku' && isset($product->buku))
                                    <div class="meta-item">
                                        <i class="ri-map-pin-line meta-icon"></i>
                                        <span class="meta-label">Lokasi:</span>
                                        <span class="meta-value">{{ $product->buku->city ?? '-' }}</span>
                                    </div>
                                @endif
                                
                                <div class="meta-item">
                                    <i class="ri-calendar-line meta-icon"></i>
                                    <span class="meta-label">Dibuat:</span>
                                    <span class="meta-value">{{ $product->created_at ? $product->created_at->format('d M Y') : '-' }}</span>
                                </div>
                                
                                <!-- Stock information - Only shown for physical books -->
                                @if($type === 'buku' && $product->stock !== null)
                                    <div class="meta-item">
                                        <i class="ri-store-line meta-icon"></i>
                                        <span class="meta-label">Stok:</span>
                                        <span class="meta-value {{ $product->stock > 0 ? 'stock-available' : 'stock-out' }}">
                                            {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                @if(isset($product->price) && $product->price == 0)
                                    <button class="btn btn-success btn-buy" onclick="downloadFreeProduct({{ $product->id }})">
                                        <i class="ri-download-line me-2"></i>Download Gratis
                                    </button>
                                @else
                                    <!-- Stock check only applies to physical books (type: buku) -->
                                    <button class="btn btn-primary btn-buy" 
                                            onclick="openProductPaymentModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $pageName ?? 'creator' }}', '{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}', '{{ $type }}')"
                                            {{ $type === 'buku' && $product->stock !== null && $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="ri-shopping-cart-line me-2"></i>
                                        {{ $type === 'buku' && $product->stock !== null && $product->stock <= 0 ? 'Stok Habis' : 'Beli Sekarang' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('products.product-payment-modal', ['paymentMethods' => $paymentMethods ?? []])
@endsection

@section('scripts')
@parent
<script>
// Wait for jQuery to be loaded
document.addEventListener('DOMContentLoaded', function() {
    // Ensure jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }
    
    console.log('jQuery is available:', typeof $);
});

function downloadFreeProduct(productId) {
    console.log('Downloading free product:', productId);
    alert('Fitur download gratis akan segera tersedia!');
}

function openProductPaymentModal(productId, productName, productPrice, pageName, productImage, productType) {
    console.log('Opening modal with:', {productId, productName, productPrice, pageName, productType});
    
    // Check if modal exists
    var modalElement = document.getElementById('productPaymentModal');
    if (!modalElement) {
        console.error('❌ Product payment modal not found!');
        alert('Modal pembayaran tidak ditemukan. Silakan refresh halaman dan coba lagi.');
        return;
    }
    
    // Set data untuk modal dengan null checks
    var productIdElement = document.getElementById('product-id');
    var productNameElement = document.getElementById('product-name');
    var productPriceElement = document.getElementById('product-price');
    var productPageNameElement = document.getElementById('product-page-name');
    var productPriceHiddenElement = document.getElementById('product-price-hidden');
    var productTypeElement = document.getElementById('product-type');
    var productTotalElement = document.getElementById('product-total');
    var inputProductQtyElement = document.getElementById('inputProductQty');
    var productQuantityElement = document.getElementById('product-quantity');
    var buyerNameElement = document.getElementById('buyer-name');
    var buyerEmailElement = document.getElementById('buyer-email');
    var buyerAddressElement = document.getElementById('buyer-address');
    var productPaymentFormElement = document.getElementById('product-payment-form');
    
    // Set values with null checks
    if (productIdElement) productIdElement.value = productId;
    if (productNameElement) productNameElement.textContent = productName;
    if (productPriceElement) productPriceElement.textContent = 'Rp' + productPrice.toLocaleString('id-ID');
    if (productPageNameElement) productPageNameElement.value = pageName;
    if (productPriceHiddenElement) productPriceHiddenElement.value = productPrice;
    if (productTypeElement) productTypeElement.value = productType;
    if (productTotalElement) productTotalElement.textContent = 'Rp' + productPrice.toLocaleString('id-ID');
    if (inputProductQtyElement) inputProductQtyElement.value = '1';
    if (productQuantityElement) productQuantityElement.value = '1';
    
    // Reset form jika ada
    if (productPaymentFormElement) {
        productPaymentFormElement.reset();
    }
    
    // Clear input fields jika ada
    if (buyerNameElement) buyerNameElement.value = '';
    if (buyerEmailElement) buyerEmailElement.value = '';
    if (buyerAddressElement) buyerAddressElement.value = '';
    
    // Set gambar produk
    var productImageElement = document.querySelector('#product-box img');
    if (productImageElement && productImage) {
        productImageElement.src = productImage;
    }
    
    // Toggle address field based on product type
    toggleAddressField(productType);
    
    // Show modal
    try {
        var modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('✅ Modal opened successfully');
    } catch (error) {
        console.error('❌ Error opening modal:', error);
        alert('Gagal membuka modal pembayaran. Silakan refresh halaman dan coba lagi.');
        return;
    }
}

function toggleAddressField(productType) {
    var addressField = document.getElementById('address-field');
    var buyerAddress = document.getElementById('buyer-address');
    
    if (productType === 'buku') {
        if (addressField) addressField.style.display = 'block';
        if (buyerAddress) buyerAddress.required = true;
    } else {
        if (addressField) addressField.style.display = 'none';
        if (buyerAddress) buyerAddress.required = false;
    }
}
</script>
@endsection 