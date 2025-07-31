<!-- Modal Payment Produk -->
<div class="modal fade pb-4" id="productPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false" tabindex="-1" aria-labelledby="productPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form autocomplete="off" id="product-payment-form" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content rounded-small border-0">
                <div class="modal-header bg-modal-header flex-column position-relative">
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ asset('template/images/icon/product-icon.png') }}" alt="" class="rounded-circle icon-100" />
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
                            <img src="{{ asset('template/images/icon/product-icon.png') }}" alt="" width="100" class="me-3" />
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
                        <div id="pg-desktop" style="display: none;">
                            <div class="row px-5 col-creator">
                                <div class="col-12 pt-2 pb-3">
                                    <h5 class="fw-bold m">Metode Pembayaran</h5>
                                    <div id="validator-payment" class="invalid-feedback">Silahkan pilih metode pembayaran.</div>
                                </div>
                                @foreach ($paymentMethods as $pg)
                                    @if ($pg['payment_type'] == 'qris')
                                        @mobile
                                            @continue
                                        @endmobile
                                    @endif
                                    <label class="col-4 mb-2 payment-list custom-radio-box form-group px-4" id="pg-list-{{ $pg['id'] }}" data-id="{{ $pg['id'] }}" data-name="{{ $pg['name'] }}" data-type="{{ $pg['payment_type'] }}" data-bank="{{ $pg['bank_name'] }}" data-description="{{ $pg['image'] }}">
                                        <input type="radio" id="input-pg-{{ $pg['id'] }}" name="payment_method_id" value="{{ $pg['id'] }}" class="custom-control-input">
                                        <div class="btn bg-pay rounded-pill btn-outline-primary btns d-flex p-3 align-items-center justify-content-center shadow">
                                            <div class="img-pay">
                                                <img src="{{ $pg['image'] }}" alt="" class="">
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <hr class="mt-5 mb-3 px-5 col-creator">
                        </div>
                        
                        <div id="pg-mobile" style="display: block;">
                            <label for="selectPG" class="col-form-label">Metode Pembayaran</label> <span class="text-danger">*</span>
                            <div id="validator-payment2" class="invalid-feedback">Payment Method is required</div>
                            <div class="row" style="padding: 12px;">
                                <select id="selectPG" name="payment_method_id" class="form-select form-select-lg mb-3" aria-label="Default select example" style="font-size: inherit;">
                                    <option value="">Pilih Metode Pembayaran</option>
                                    @foreach ($paymentMethods as $pg)
                                        @if ($pg['payment_type'] == 'qris')
                                            @mobile
                                                @continue
                                            @endmobile
                                        @endif
                                        <option data-img_src="{{ $pg['image'] }}" value="{{ $pg['id'] }}">{{ $pg['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
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

<!-- Snap.js already loaded in layout -->

<style>
.payment-list.selected {
    border: 2px solid #007bff !important;
    background-color: #f8f9fa !important;
}
.payment-list {
    cursor: pointer;
    transition: all 0.3s ease;
}
.payment-list:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>

<script>

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
    
    // Snap.js is already loaded in layout
    
    // Initial check with delay
    setTimeout(checkSnapAvailability, 1000);
    
    // Check Snap availability when modal is shown
    $('#productPaymentModal').on('shown.bs.modal', function() {
        console.log('Modal shown, checking Snap availability...');
        setTimeout(checkSnapAvailability, 500);
    });

    // Payment method selection styling
    $('.payment-list').click(function() {
        $('.payment-list').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
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
                                
                                // Snap.js should be available from layout
                                
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
</script> 