@extends('layouts.template-body')

@section('title', 'Email Monitoring')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">📧 Email Monitoring - Product Purchases</h4>
                </div>
                <div class="card-body">
                    <!-- Email Status Summary -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Total Purchases</h5>
                                    <h3>{{ $totalPurchases }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>Successful Payments</h5>
                                    <h3>{{ $successfulPayments }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Digital Products</h5>
                                    <h3>{{ $digitalProducts }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5>Pending</h5>
                                    <h3>{{ $pendingPayments }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Purchases Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Type</th>
                                    <th>Buyer</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->product->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $purchase->product->type === 'buku' ? 'secondary' : 'primary' }}">
                                            {{ ucfirst($purchase->product->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $purchase->buyer_name }}</td>
                                    <td>{{ $purchase->email }}</td>
                                    <td>
                                        @if($purchase->status === 'success')
                                            <span class="badge bg-success">Success</span>
                                        @elseif($purchase->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($purchase->status === 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($purchase->status) }}</span>
                                        @endif
                                    </td>
                                    <td>Rp{{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $purchase->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if(in_array($purchase->product->type, ['ebook', 'ecourse', 'digital']) && $purchase->status === 'success')
                                            <button class="btn btn-sm btn-primary" onclick="testEmail({{ $purchase->id }})">
                                                📧 Test Email
                                            </button>
                                        @endif
                                        <a href="{{ route('product.download', $purchase->id) }}" class="btn btn-sm btn-success" target="_blank">
                                            📥 Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Email Modal -->
<div class="modal fade" id="testEmailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="testEmail" class="form-label">Test Email Address:</label>
                    <input type="email" class="form-control" id="testEmail" placeholder="test@example.com">
                </div>
                <div id="emailTestResult"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendTestEmail()">Send Test Email</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentPurchaseId = null;

function testEmail(purchaseId) {
    currentPurchaseId = purchaseId;
    $('#testEmailModal').modal('show');
}

function sendTestEmail() {
    const testEmail = $('#testEmail').val();
    const resultDiv = $('#emailTestResult');
    
    if (!testEmail) {
        resultDiv.html('<div class="alert alert-danger">Please enter a test email address</div>');
        return;
    }
    
    resultDiv.html('<div class="alert alert-info">Sending test email...</div>');
    
    fetch(`/admin/test-product-email/${currentPurchaseId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            test_email: testEmail
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.html('<div class="alert alert-success">✅ Test email sent successfully!</div>');
        } else {
            resultDiv.html(`<div class="alert alert-danger">❌ ${data.message}</div>`);
        }
    })
    .catch(error => {
        resultDiv.html(`<div class="alert alert-danger">❌ Error: ${error.message}</div>`);
    });
}
</script>
@endsection 