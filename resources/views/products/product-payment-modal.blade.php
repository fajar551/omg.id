<!-- Modal Payment Produk -->
<div class="modal fade pb-4" id="productPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false" tabindex="-1" aria-labelledby="productPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form autocomplete="off" id="product-payment-form" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content rounded-small border-0">
                <div class="modal-header bg-modal-header flex-column position-relative">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/img/image.png') }}" alt="" class="rounded-circle icon-100" />
                        <div class="content-profile mx-3" style="text-align: start !important">
                            <h6 class="text-white font-creator fw-semibold">
                                Pembelian Produk
                            </h6>
                            <span class="fw-semibold text-white">
                                <span class="text-white font-creator">Produk Digital</span>
                            </span>
                        </div>
                    </div>
                    <div class="pb-4 position-absolute" style="right: 0">
                        <button type="button" class="btn btn-transparent btn-sm border-0 btn-closes bg-transparent me-2" data-bs-dismiss="modal" aria-label="Close">
                            <img src="{{ asset('template/images/ic_close.svg') }}" alt="" />
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="product-notif"></div>
                    
                    <!-- Product Details -->
                    <div class="card-items" id="product-box">
                        <div class="card-body px-5 col-creatoreen text-center">
                            <img src="{{ asset('assets/img/image.png') }}" alt="" width="100" class="me-3" />
                            <div class="body-title">
                                <h4 class="text-center fw-bold" id="product-name">
                                    Nama Produk
                                </h4>
                                <div class="price">
                                    <span id="product-price">Rp0</span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-6">
                                        <div class="d-flex justify-content-center align-self-center h-100 spinner-item">
                                            <div class="justify-content-center align-self-center">
                                                <div class="item">
                                                    <div class="input-quantity number-spinner w-100">
                                                        <div class="input-group input-group-sm">
                                                            <button class="btn btn-danger btn-quantity p-0 me-2" type="button" data-dir="dwn" id="button-product-minus">
                                                                <h5>-</h5>
                                                            </button>
                                                            <input type="text" id="inputProductQty" onkeypress="return GeInttOnly(event)" class="form-control text-center mx-1 disabled rounded-pill" value="1" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                            <button class="btn btn-primary btn-quantity p-0 ms-2" type="button" data-dir="up" id="button-product-plus">
                                                                <h5>+</h5>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buyer Information -->
                    <div class="">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="buyer-name" class="col-form-label">Nama Pembeli</label> <span class="text-danger">*</span>
                                    <input type="text" name="buyer_name" class="form-control" id="buyer-name" placeholder="Nama Pembeli" autocomplete="off" required>
                                    <div class="invalid-feedback" id="feedback-buyer-name">Nama wajib diisi</div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="buyer-email" class="col-form-label">Email Pembeli</label> <span class="text-danger">*</span>
                                    <input type="email" name="buyer_email" class="form-control" id="buyer-email" placeholder="email@example.com" autocomplete="off" required>
                                    <div class="invalid-feedback">Email harus berupa alamat surel yang valid.</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Field for Books -->
                        <div class="row mb-2" id="address-field" style="display: none;">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="buyer-address" class="col-form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="buyer-address" name="buyer_address" placeholder="Masukkan alamat lengkap untuk pengiriman buku..." rows="3"></textarea>
                                    <div class="invalid-feedback" id="feedback-buyer-address">Alamat wajib diisi untuk pengiriman buku</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                            <label for="buyer-message" class="col-form-label">Pesan (Opsional)</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" placeholder="Pesan untuk penjual..." id="buyer-message" name="buyer_message"></textarea>
                            </div>
                        </div>

                        <!-- Payment Methods -->
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <label class="col-form-label">Metode Pembayaran</label> <span class="text-danger">*</span>
                                <div class="payment-methods">
                                    <div class="row">
                                        @foreach($paymentMethods as $method)
                                            <div class="col-md-6 col-sm-12 mb-2">
                                                <div class="payment-list p-2 border rounded" data-method-id="{{ $method->id }}" onclick="selectPaymentMethod({{ $method->id }}); return false;">
                                                    <div class="d-flex align-items-center">
                                                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" class="me-2" required>
                                                        <div class="flex-grow-1">
                                                            <strong class="d-block">{{ $method->name }}</strong>
                                                            @if($method->description)
                                                                <small class="text-muted">{{ $method->description }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="invalid-feedback d-none" id="validator-payment">Pilih metode pembayaran</div>
                                <div class="invalid-feedback d-none" id="validator-payment2">Pilih metode pembayaran</div>
                            </div>
                        </div>

                        <!-- Total Price -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="text-primary fw-semibold">Total</h5>
                            <h3 class="text-primary fw-semibold" id="product-total">Rp0</h3>
                        </div>

                        <div class="mt-3">
                            <div id="tmp"></div>
                            <input type="hidden" name="product_id" id="product-id">
                            <input type="hidden" name="page_name" id="product-page-name">
                            <input type="hidden" name="product_price" id="product-price-hidden">
                            <input type="hidden" name="quantity" id="product-quantity" value="1">
                            <input type="hidden" name="product_type" id="product-type">
                                <button type="submit" class="btn btn-primary rounded-pill w-100" id="btn-product-pay">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Ensure Snap.js is loaded -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>

<style>
.payment-list.selected {
    border: 2px solid #007bff !important;
    background-color: #f8f9fa !important;
    box-shadow: 0 2px 8px rgba(0,123,255,0.2) !important;
}
.payment-list {
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 60px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.payment-list:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-color: #007bff;
    background-color: #f8f9fa;
}
.payment-list:active {
    transform: translateY(0);
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
.payment-list input[type="radio"] {
    margin-right: 8px;
    pointer-events: auto;
    z-index: 10;
    position: relative;
}
.payment-list strong {
    font-size: 14px;
    margin-bottom: 2px;
    color: #333;
}
.payment-list small {
    font-size: 11px;
    line-height: 1.2;
    color: #666;
}
.payment-methods .row {
    margin: 0 -5px;
}
.payment-methods .col-md-6 {
    padding: 0 5px;
}
.payment-list::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(0,123,255,0.05), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.payment-list:hover::before {
    opacity: 1;
}
.payment-list.selected::before {
    background: linear-gradient(45deg, transparent, rgba(0,123,255,0.1), transparent);
    opacity: 1;
}
</style>

<script>

// Wait for jQuery to be available
function initializeModalScripts() {
    if (typeof $ === 'undefined') {
        console.error('jQuery is not available, retrying in 100ms...');
        setTimeout(initializeModalScripts, 100);
        return;
    }
    
    console.log('jQuery is available, initializing modal scripts...');
    
    $(document).ready(function() {
    // Debug Snap availability when modal is ready
    console.log('Product payment modal loaded');
    
    // Function to check Snap availability
    function checkSnapAvailability() {
        console.log('Checking Snap availability...');
        console.log('Snap available:', typeof snap !== 'undefined');
        if (typeof snap !== 'undefined') {
            console.log('Snap object in modal:', snap);
            console.log('Snap.pay function:', typeof snap.pay);
        }
        return typeof snap !== 'undefined' && snap.pay;
    }
    
    // Function to ensure Snap.js is loaded
    function ensureSnapLoaded() {
        if (typeof snap === 'undefined') {
            console.log('Snap not found, loading Snap.js...');
            // Create script element
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
            script.setAttribute('data-client-key', 'SB-Mid-client-yXcEzjhVAqWaf3qm');
            script.onload = function() {
                console.log('✅ Snap.js loaded dynamically');
                checkSnapAvailability();
            };
            script.onerror = function() {
                console.error('❌ Failed to load Snap.js dynamically');
            };
            document.head.appendChild(script);
        } else {
            console.log('✅ Snap.js already available');
        }
    }
    
    // Initial check with delay
    setTimeout(function() {
        ensureSnapLoaded();
        checkSnapAvailability();
    }, 1000);
    
    // Check Snap availability when modal is shown
    $('#productPaymentModal').on('shown.bs.modal', function() {
        console.log('Modal shown, checking Snap availability...');
        setTimeout(function() {
            ensureSnapLoaded();
            checkSnapAvailability();
        }, 500);
    });

    // Function to select payment method
    window.selectPaymentMethod = function(methodId) {
        console.log('Selecting payment method:', methodId);
        
        // Remove selected class from all payment methods
        $('.payment-list').removeClass('selected');
        
        // Add selected class to clicked method
        $('.payment-list[data-method-id="' + methodId + '"]').addClass('selected');
        
        // Check the radio button
        $('input[name="payment_method_id"][value="' + methodId + '"]').prop('checked', true);
        
        // Clear validation messages
        $('#validator-payment').removeClass('d-block').addClass('d-none');
        $('#validator-payment2').removeClass('d-block').addClass('d-none');
        
        console.log('Payment method selected:', methodId);
    };

    // Add event listeners for radio buttons
    $(document).on('change', 'input[name="payment_method_id"]', function() {
        var methodId = $(this).val();
        console.log('Radio button changed:', methodId);
        selectPaymentMethod(methodId);
    });

    // Form submission
    $('#product-payment-form').submit(function(e) {
        e.preventDefault();
        
        console.log('Form submitted');
        
        // Validate form
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return false;
        }
        
        // Get selected payment method
        var paymentMethodId = $('input[name="payment_method_id"]:checked').val() || $('#selectPG').val();
        if (!paymentMethodId) {
            $('#validator-payment').addClass('d-block').removeClass('d-none');
            $('#validator-payment2').addClass('d-block').removeClass('d-none');
            return false;
        }
        
        // Clear validation messages
        $('#validator-payment').removeClass('d-block').addClass('d-none');
        $('#validator-payment2').removeClass('d-block').addClass('d-none');
        
        // Disable button
        $('#btn-product-pay').prop('disabled', true).text('Memproses...');
        
        // Prepare form data
        var formData = new FormData(this);
        formData.append('payment_method_id', paymentMethodId);
        
        console.log('Sending payment request...');
        console.log('Form data:', Object.fromEntries(formData));
        
        $.ajax({
            url: '{{ route("product.payment.process") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                console.log('AJAX request starting...');
                // Add CSRF token to headers
                var token = $('meta[name="csrf-token"]').attr('content');
                if (token) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(response) {
                console.log('AJAX Response received:', response);
                if (response.success) {
                    console.log('Payment response success, snap_token:', response.snap_token);
                    
                    // Function to trigger Snap payment with retry mechanism
                    function triggerSnapPayment(retryCount = 0) {
                        console.log('=== Triggering Snap Payment ===');
                        console.log('Attempt:', retryCount + 1);
                        console.log('Snap available:', typeof snap !== 'undefined');
                        console.log('Snap object:', snap);
                        console.log('Snap.pay function:', typeof snap.pay);
                        console.log('Window.snap:', window.snap);
                        
                        // Ensure Snap is loaded
                        ensureSnapLoaded();
                        
                        // Check if snap is available
                        if (checkSnapAvailability()) {
                            try {
                                console.log('✅ Snap is available, calling snap.pay...');
                                console.log('Token:', response.snap_token);
                                
                                // Close the payment modal first
                                $('#productPaymentModal').modal('hide');
                                
                                // Small delay to ensure modal is closed
                                setTimeout(function() {
                                    console.log('About to call snap.pay...');
                                    
                                    // Call snap.pay with proper error handling
                                    snap.pay(response.snap_token, {
                                        onSuccess: function(result) {
                                            console.log('✅ Payment success:', result);
                                            // Redirect to success page
                                            window.location.href = '{{ route("product.payment.status", ["purchase_id" => ":purchase_id"]) }}'.replace(':purchase_id', response.purchase_id);
                                        },
                                        onPending: function(result) {
                                            console.log('⏳ Payment pending:', result);
                                            alert('Pembayaran pending. Silakan selesaikan pembayaran Anda.');
                                        },
                                        onError: function(result) {
                                            console.log('❌ Payment error:', result);
                                            alert('Pembayaran gagal. Silakan coba lagi.');
                                        },
                                        onClose: function() {
                                            console.log('🚪 Payment popup closed');
                                            alert('Pembayaran dibatalkan.');
                                        }
                                    });
                                    
                                    console.log('✅ snap.pay called successfully');
                                }, 300);
                            } catch (error) {
                                console.error('❌ Snap.pay error:', error);
                                alert('Terjadi kesalahan saat membuka payment popup: ' + error.message);
                                $('#btn-product-pay').prop('disabled', false).text('Bayar Sekarang');
                            }
                        } else {
                            console.error('❌ Snap is not available, retry count:', retryCount);
                            if (retryCount < 5) { // Increase retry attempts
                                console.log('Retrying in 2000ms...');
                                
                                // Try to load Snap.js again
                                ensureSnapLoaded();
                                
                                setTimeout(function() {
                                    triggerSnapPayment(retryCount + 1);
                                }, 2000);
                            } else {
                                console.error('❌ Max retries reached, Snap still not available');
                                alert('Midtrans Snap tidak tersedia. Silakan refresh halaman dan coba lagi.');
                                $('#btn-product-pay').prop('disabled', false).text('Bayar Sekarang');
                            }
                        }
                    }
                    
                    // Start the retry mechanism
                    triggerSnapPayment();
                } else {
                    alert(response.message || 'Terjadi kesalahan.');
                    $('#btn-product-pay').prop('disabled', false).text('Bayar Sekarang');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {xhr: xhr, status: status, error: error});
                var response = xhr.responseJSON;
                console.error('Response JSON:', response);
                
                var errorMessage = 'Terjadi kesalahan saat memproses pembayaran.';
                if (response && response.message) {
                    errorMessage = response.message;
                } else if (xhr.status === 419) {
                    errorMessage = 'CSRF token mismatch. Silakan refresh halaman dan coba lagi.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Route tidak ditemukan. Silakan refresh halaman dan coba lagi.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Kesalahan server. Silakan coba lagi nanti.';
                }
                
                alert(errorMessage);
                $('#btn-product-pay').prop('disabled', false).text('Bayar Sekarang');
            }
        });
    });

    // Payment method selection
    $('input[name="payment_method_id"]').change(function() {
        var paymentMethodId = $(this).val();
        console.log('Payment method selected (desktop):', paymentMethodId);
    });
    $('#selectPG').change(function() {
        var paymentMethodId = $(this).val();
        console.log('Payment method selected (mobile):', paymentMethodId);
    });

    // Quantity spinner functionality
    $('#button-product-plus').click(function() {
        var qty = parseInt($('#inputProductQty').val());
        $('#inputProductQty').val(qty + 1);
        updateTotal();
    });

    $('#button-product-minus').click(function() {
        var qty = parseInt($('#inputProductQty').val());
        if (qty > 1) {
            $('#inputProductQty').val(qty - 1);
            updateTotal();
        }
    });

    function updateTotal() {
        var qty = parseInt($('#inputProductQty').val());
        var price = parseInt($('#product-price-hidden').val());
        var total = qty * price;
        $('#product-total').text('Rp' + total.toLocaleString('id-ID'));
        $('#product-quantity').val(qty);
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
    
    // Clear error feedback when user starts typing
    $('#buyer-email').on('input', function() {
        $('#feedback-buyer-email').removeClass('d-block').addClass('d-none');
    });
    });
}

// Initialize modal scripts when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeModalScripts();
});

// Also try to initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeModalScripts);
} else {
    initializeModalScripts();
}
</script> 