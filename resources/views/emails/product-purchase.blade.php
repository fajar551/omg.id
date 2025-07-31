<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Purchase - {{ $purchase->product->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .product-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .download-section {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .btn-download {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .price {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Thank You for Your Purchase!</h1>
        <p>Your product is ready for download</p>
    </div>
    
    <div class="content">
        <h2>Hello {{ $purchase->buyer_name }}!</h2>
        
        <p>Thank you for purchasing <strong>{{ $purchase->product->name }}</strong>. Your order has been processed successfully.</p>
        
        <div class="product-info">
            <h3>📦 Product Details</h3>
            <p><strong>Product:</strong> {{ $purchase->product->name }}</p>
            <p><strong>Type:</strong> {{ ucfirst($purchase->product->type) }}</p>
            <p><strong>Quantity:</strong> {{ $purchase->quantity }}</p>
            <p><strong>Total Amount:</strong> <span class="price">Rp{{ number_format($purchase->total_price, 0, ',', '.') }}</span></p>
            <p><strong>Order Date:</strong> {{ $purchase->created_at->format('d M Y H:i') }}</p>
        </div>
        
        @if($purchase->product->type === 'ebook')
            <div class="download-section">
                <h3>📚 Download Your Ebook</h3>
                <p>Click the button below to download your ebook:</p>
                <a href="{{ route('product.download', ['purchase_id' => $purchase->id]) }}" class="btn-download">
                    📥 Download Ebook
                </a>
                <p><small>Link will expire in 7 days</small></p>
            </div>
        @elseif($purchase->product->type === 'ecourse')
            <div class="download-section">
                <h3>🎓 Access Your E-Course</h3>
                <p>Click the button below to access your e-course:</p>
                <a href="{{ route('product.download', ['purchase_id' => $purchase->id]) }}" class="btn-download">
                    🎯 Access E-Course
                </a>
                <p><small>Access link will expire in 30 days</small></p>
            </div>
        @elseif($purchase->product->type === 'digital')
            <div class="download-section">
                <h3>💾 Download Your Digital Product</h3>
                <p>Click the button below to download your digital product:</p>
                <a href="{{ route('product.download', ['purchase_id' => $purchase->id]) }}" class="btn-download">
                    📥 Download Digital Product
                </a>
                <p><small>Link will expire in 7 days</small></p>
            </div>
        @elseif($purchase->product->type === 'buku')
            <div class="download-section">
                <h3>📦 Physical Book Order</h3>
                <p>Your physical book will be shipped to:</p>
                <p><strong>Address:</strong> {{ $purchase->shipping_address }}</p>
                <p><small>Estimated delivery: 3-5 business days</small></p>
            </div>
        @endif
        
        <div style="margin-top: 30px; padding: 20px; background: #f0f8ff; border-radius: 8px;">
            <h3>📞 Need Help?</h3>
            <p>If you have any questions about your purchase, please contact us:</p>
            <p>📧 Email: support@omg.id</p>
            <p>📱 WhatsApp: +62 812-3456-7890</p>
        </div>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} OMG.ID. All rights reserved.</p>
        <p>This email was sent to {{ $purchase->email }}</p>
    </div>
</body>
</html> 