@extends('layouts.checkout')

@section('styles')
<style>
/* Payment Page Responsive */
.product-payment-image {
    min-width: 80px;
    width: 80px;
    height: 80px;
    object-fit: cover;
}

/* Mobile Responsive */
@media (max-width: 767.98px) {
    .product-payment-image {
        width: 60px;
        height: 60px;
        min-width: 60px;
        margin-bottom: 1rem;
    }
    
    .container {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}

@media (max-width: 575.98px) {
    .product-payment-image {
        width: 50px;
        height: 50px;
        min-width: 50px;
    }
}

/* Fix for flex layout on mobile */
@media (max-width: 767.98px) {
    .d-flex.flex-column.flex-sm-row {
        align-items: center;
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
                <h4 class="fw-bold mb-0">Payment</h4>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12">
                    <div class="card creators rounded-small shadow border-0 p-2 card-dark">
                        <div class="card-header bg-transparent border-0 p-1">
                            <h6 class="fw-semibold m-0">Payment Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-3">Product Information</h6>
                                    <div class="d-flex align-items-center mb-3 flex-column flex-sm-row">
                                        <img src="{{ $purchase->product->image ? asset('storage/' . $purchase->product->image) : asset('assets/img/image.png') }}" 
                                             class="rounded me-3 product-payment-image" alt="{{ $purchase->product->name }}" style="width: 80px; height: 80px; object-fit: cover; min-width: 80px;">
                                        <div>
                                            <h6 class="fw-semibold mb-1">{{ $purchase->product->name }}</h6>
                                            <p class="text-muted small mb-1">{{ $purchase->product->description }}</p>
                                            <span class="text-muted">Quantity: {{ $purchase->quantity }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="fw-semibold mb-3">Purchase Information</h6>
                                    <div class="mb-2">
                                        <span class="text-muted">Buyer:</span>
                                        <span class="fw-semibold">{{ $purchase->buyer_name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Email:</span>
                                        <span class="fw-semibold">{{ $purchase->email }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Total Amount:</span>
                                        <span class="fw-bold text-success">Rp{{ number_format($purchase->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Payment Method:</span>
                                        <div class="d-flex align-items-center mt-1">
                                            <div class="payment-logo me-2" style="width: 40px; height: 25px; background-color: {{ $purchase->payment_method === 'Sahabat Sampoerna' ? '#2E7D32' : ($purchase->payment_method === 'Dana' ? '#0077FF' : ($purchase->payment_method === 'Ovo' ? '#4C3494' : ($purchase->payment_method === 'Gopay' ? '#00AAE4' : ($purchase->payment_method === 'Link aja' ? '#FF6B35' : ($purchase->payment_method === 'Shopee Pay' ? '#EE4D2D' : '#000000'))))) }}; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 10px;">
                                                {{ strtoupper(substr($purchase->payment_method, 0, 3)) }}
                                            </div>
                                            <span class="fw-semibold">{{ $purchase->payment_method }}</span>
                                        </div>
                                    </div>
                                    @if($purchase->shipping_address)
                                        <div class="mb-2">
                                            <span class="text-muted">Shipping Address:</span>
                                            <span class="fw-semibold">{{ $purchase->shipping_address }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="text-center">
                                <h6 class="fw-semibold mb-3">Select Payment Method</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card border p-3 text-center" style="cursor: pointer;">
                                            <i class="ri-bank-card-line fs-2 text-primary mb-2"></i>
                                            <div>Bank Transfer</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card border p-3 text-center" style="cursor: pointer;">
                                            <i class="ri-wallet-line fs-2 text-success mb-2"></i>
                                            <div>E-Wallet</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card border p-3 text-center" style="cursor: pointer;">
                                            <i class="ri-cash-line fs-2 text-warning mb-2"></i>
                                            <div>Cash on Delivery</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button class="btn btn-primary btn-lg px-5">
                                    <i class="ri-lock-line me-2"></i>Pay Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 