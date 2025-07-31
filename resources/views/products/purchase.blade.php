@extends('layouts.checkout')

@section('styles')
<style>
/* Product Card Responsive */
.product-card, .product-card-public {
    min-height: 280px;
    transition: all 0.3s ease;
}

.product-image {
    height: 160px !important;
    object-fit: cover;
    width: 100%;
}

.product-badge {
    font-size: 0.8em !important;
    padding: 4px 12px !important;
    border-radius: 6px !important;
}

.product-title {
    font-size: 0.9rem;
    line-height: 1.3;
    min-height: 2.4rem;
}

.product-location {
    font-size: 0.75rem;
}

.product-price {
    font-size: 0.8rem;
}

/* Purchase Page Responsive */
.product-purchase-image {
    min-width: 120px;
    width: 120px;
    height: 120px;
    object-fit: cover;
}

.payment-method-name {
    font-size: 0.75rem;
}

/* Mobile Responsive */
@media (max-width: 767.98px) {
    .product-card, .product-card-public {
        min-height: 250px;
    }
    
    .product-image {
        height: 140px !important;
    }
    
    .product-title {
        font-size: 0.85rem;
        min-height: 2.2rem;
    }
    
    .product-badge {
        font-size: 0.7em !important;
        padding: 3px 8px !important;
    }
    
    .product-purchase-image {
        width: 100px;
        height: 100px;
        min-width: 100px;
    }
    
    .payment-method-name {
        font-size: 0.7rem;
    }
    
    .container {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}

@media (max-width: 575.98px) {
    .product-card, .product-card-public {
        min-height: 220px;
    }
    
    .product-image {
        height: 120px !important;
    }
    
    .product-title {
        font-size: 0.8rem;
        min-height: 2rem;
    }
    
    .product-purchase-image {
        width: 80px;
        height: 80px;
        min-width: 80px;
    }
    
    .payment-method-name {
        display: none;
    }
    
    .payment-logo {
        width: 35px !important;
        height: 22px !important;
        font-size: 8px !important;
    }
}

/* Tablet Responsive */
@media (min-width: 768px) and (max-width: 991.98px) {
    .product-card, .product-card-public {
        min-height: 260px;
    }
    
    .product-image {
        height: 150px !important;
    }
    
    .product-title {
        font-size: 0.88rem;
    }
}

/* Ensure consistent card heights */
.card-body {
    display: flex;
    flex-direction: column;
}

.content-title {
    flex-grow: 1;
}

/* Fix for flex layout on mobile */
@media (max-width: 767.98px) {
    .d-flex.flex-column.flex-sm-row {
        align-items: center;
    }
    
    .product-purchase-image {
        margin-bottom: 1rem;
    }
}
</style>
@endsection

@section('content')
<div class="container px-lg-5 px-3 pt-3 mt-5">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('creator.index', ['page_name' => $pageName]) }}" class="btn btn-link text-dark me-3">
                    <i class="ri-arrow-left-line fs-4"></i>
                </a>
                <h4 class="fw-bold mb-0">Checkout</h4>
            </div>
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <!-- PRODUCT Section -->
                        <div class="col-12 mb-4">
                            <div class="card creators rounded-small shadow border-0 p-2 card-dark">
                                <div class="card-header bg-transparent border-0 p-1">
                                    <h6 class="fw-semibold m-0">PRODUCT</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3 flex-column flex-sm-row">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/img/image.png') }}" 
                                             class="rounded me-3 product-purchase-image" alt="{{ $product->name }}" style="width: 120px; height: 120px; object-fit: cover; min-width: 120px;">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                                            <p class="text-muted small mb-2">{{ $product->description }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted">1x</span>
                                                <span class="fw-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- BUYER INFO Section -->
                        <div class="col-12 mb-4">
                            <div class="card creators rounded-small shadow border-0 p-2 card-dark">
                                <div class="card-header bg-transparent border-0 p-1">
                                    <h6 class="fw-semibold m-0">BUYER INFO</h6>
                                </div>
                                <div class="card-body">
                                    <form id="checkoutForm" action="{{ route('product.purchase', ['page_name' => $pageName, 'id' => $product->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label d-flex align-items-center">
                                                <span class="text-danger me-1">*</span> Email
                                                <i class="ri-information-line ms-2 text-muted"></i>
                                            </label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                <span class="text-danger me-1">*</span> Name
                                            </label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                        </div>
                                        
                                        @if($product->type === 'buku')
                                            <div class="mb-3">
                                                <label for="shipping_address" class="form-label">
                                                    <span class="text-danger me-1">*</span> Shipping Address
                                                </label>
                                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" placeholder="Enter your complete shipping address" required></textarea>
                                                <small class="text-muted">Please provide your complete address for book delivery</small>
                                            </div>
                                        @endif
                                        
                                        <div class="mb-3" id="phone_number_field" style="display: none;">
                                            <label for="phone_number" class="form-label">
                                                <span class="text-danger me-1">*</span> Phone Number
                                            </label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="628123456789" required>
                                            <small class="text-muted">Enter your phone number for e-wallet payment</small>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-lg-4 col-md-12">
                    <div class="card creators rounded-small shadow border-0 p-2 card-dark">
                        <div class="card-header bg-transparent border-0 p-1">
                            <h6 class="fw-semibold m-0">PAYMENT DETAIL</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>Rp <span id="subtotal">{{ number_format($product->price, 0, ',', '.') }}</span></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount</span>
                                    <span>- Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Convenience fee</span>
                                    <span>Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>TOTAL</span>
                                    <span>Rp <span id="total">{{ number_format($product->price, 0, ',', '.') }}</span></span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <button class="btn btn-outline-primary w-100 mb-2">
                                    <i class="ri-percent-line me-2"></i>Add Voucher
                                </button>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-semibold mb-3">Payment Methods</h6>
                                <div class="row">
                                    @foreach($paymentMethods as $method)
                                        <div class="col-6 col-sm-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment_method_id" id="payment_{{ $method->id }}" value="{{ $method->id }}" {{ $loop->first ? 'checked' : '' }}>
                                                <label class="form-check-label d-flex align-items-center" for="payment_{{ $method->id }}">
                                                    <div class="payment-logo me-2" style="width: 40px; height: 25px; background-color: {{ $method->payment_type === 'bank_transfer' ? '#2E7D32' : ($method->payment_type === 'dana' ? '#0077FF' : ($method->payment_type === 'ovo' ? '#4C3494' : ($method->payment_type === 'gopay' ? '#00AAE4' : ($method->payment_type === 'linkaja' ? '#FF6B35' : ($method->payment_type === 'shopeepay' ? '#EE4D2D' : '#000000'))))) }}; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 10px;">
                                                        {{ strtoupper(substr($method->name, 0, 3)) }}
                                                    </div>
                                                    <span class="small payment-method-name">{{ $method->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="ri-shield-check-line text-success me-2"></i>
                                        <span class="small">Secure Payment</span>
                                    </div>
                                    <small class="text-muted">All your payments are secured with RSA encryption</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label small" for="termsCheck">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Use</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="marketingCheck">
                                    <label class="form-check-label small" for="marketingCheck">
                                        I agree that my email and phone number may be used to receive newsletters or marketing messages, which I can unsubscribe from at any time.
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" form="checkoutForm" class="btn btn-success w-100 fw-bold" id="buyNowBtn">
                                Buy Now - IDR <span id="buyNowAmount">{{ number_format($product->price, 0, ',', '.') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('checkoutForm');
    const termsCheck = document.getElementById('termsCheck');
    const phoneNumberField = document.getElementById('phone_number_field');
    const phoneNumberInput = document.getElementById('phone_number');
    
    // Payment method selection
    const paymentMethods = document.querySelectorAll('input[name="payment_method_id"]');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const selectedMethod = this.value;
            const methodData = @json($paymentMethods);
            const selectedMethodData = methodData.find(m => m.id == selectedMethod);
            
            if (selectedMethodData && selectedMethodData.payment_type !== 'bank_transfer') {
                phoneNumberField.style.display = 'block';
                phoneNumberInput.required = true;
            } else {
                phoneNumberField.style.display = 'none';
                phoneNumberInput.required = false;
            }
        });
    });
    
    form.addEventListener('submit', function(e) {
        if (!termsCheck.checked) {
            e.preventDefault();
            alert('Please agree to the Terms of Use to continue.');
        }
    });
});
</script>
@endsection 