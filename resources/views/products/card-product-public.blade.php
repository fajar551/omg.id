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
@endphp
<div class="card card-content shadow-sm shadow-hover-sm border rounded-small inner-card-dark product-card-public" style="transition: all 0.3s ease; min-height: 280px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
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
        
        <!-- Payment Buttons -->
        <div class="mt-2">
            @if($isFree)
                <button class="btn btn-success btn-sm w-100 rounded-pill" onclick="downloadFreeProduct({{ $product->id }})">
                    <i class="ri-download-line me-1"></i>Download Gratis
                </button>
            @else
                <button class="btn btn-primary btn-sm w-100 rounded-pill" onclick="openProductPaymentModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $pageName ?? 'creator' }}', '{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}', '{{ $type }}')">
                    <i class="ri-shopping-cart-line me-1"></i>Beli Sekarang
                </button>
            @endif
        </div>
    </div>
</div>

<script>
function openProductPaymentModal(productId, productName, productPrice, pageName, productImage, productType) {
    console.log('Opening modal with:', {productId, productName, productPrice, pageName, productType});
    
    // Set data untuk modal
    document.getElementById('product-id').value = productId;
    document.getElementById('product-name').textContent = productName;
    document.getElementById('product-price').textContent = 'Rp' + productPrice.toLocaleString('id-ID');
    document.getElementById('product-page-name').value = pageName;
    document.getElementById('product-price-hidden').value = productPrice;
    document.getElementById('product-type').value = productType;
    
    // Set gambar produk
    var productImageElement = document.querySelector('#product-box img');
    if (productImageElement) {
        productImageElement.src = productImage;
    }
    
    // Reset form dan kosongkan nama dan email
    document.getElementById('product-payment-form').reset();
    document.getElementById('buyer-name').value = '';
    document.getElementById('buyer-email').value = '';
    document.getElementById('buyer-address').value = '';
    document.getElementById('product-total').textContent = 'Rp' + productPrice.toLocaleString('id-ID');
    document.getElementById('inputProductQty').value = '1';
    document.getElementById('product-quantity').value = '1';
    
    // Toggle address field based on product type
    toggleAddressField(productType);
    
    // Show modal
    var modal = new bootstrap.Modal(document.getElementById('productPaymentModal'));
    modal.show();
    
    // Debug: Log field values after setting
    console.log('Field values after setting:');
    console.log('product-id:', document.getElementById('product-id').value);
    console.log('product-type:', document.getElementById('product-type').value);
    console.log('product-page-name:', document.getElementById('product-page-name').value);
}

// Function to show/hide address field based on product type
function toggleAddressField(productType) {
    if (productType === 'buku') {
        $('#address-field').show();
        $('#buyer-address').prop('required', true);
    } else {
        $('#address-field').hide();
        $('#buyer-address').prop('required', false);
    }
}

// Function to download free product
function downloadFreeProduct(productId) {
    console.log('Downloading free product:', productId);
    // Implement free product download logic here
    alert('Fitur download gratis akan segera tersedia!');
}
</script>

 