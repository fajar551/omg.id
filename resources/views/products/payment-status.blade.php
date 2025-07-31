@extends('layouts.template-support')

@section('title', 'Status Pembayaran Produk')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Status Pembayaran Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Detail Pembelian</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Order ID:</strong></td>
                                    <td>{{ $purchase->order_id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Produk:</strong></td>
                                    <td>{{ $purchase->product->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah:</strong></td>
                                    <td>{{ $purchase->quantity }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Harga:</strong></td>
                                    <td>Rp{{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($purchase->status == 'success')
                                            <span class="badge bg-success">Berhasil</span>
                                        @elseif($purchase->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                                        @elseif($purchase->status == 'failed')
                                            <span class="badge bg-danger">Gagal</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($purchase->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Pembeli</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td>{{ $purchase->buyer_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $purchase->buyer_email }}</td>
                                </tr>
                                @if($purchase->buyer_address)
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td>{{ $purchase->buyer_address }}</td>
                                </tr>
                                @endif
                                @if($purchase->buyer_message)
                                <tr>
                                    <td><strong>Pesan:</strong></td>
                                    <td>{{ $purchase->buyer_message }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        @if($purchase->status == 'success')
                            <div class="alert alert-success">
                                <h5>Pembayaran Berhasil!</h5>
                                <p>Terima kasih telah membeli produk kami. Detail produk akan dikirimkan ke email Anda.</p>
                            </div>
                        @elseif($purchase->status == 'pending')
                            <div class="alert alert-warning">
                                <h5>Menunggu Pembayaran</h5>
                                <p>Silakan selesaikan pembayaran Anda. Pembayaran akan otomatis terverifikasi setelah proses selesai.</p>
                            </div>
                        @elseif($purchase->status == 'failed')
                            <div class="alert alert-danger">
                                <h5>Pembayaran Gagal</h5>
                                <p>Maaf, pembayaran Anda gagal. Silakan coba lagi atau hubungi customer service.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('creator.index', ['page_name' => $purchase->product->user->page->page_url ?? 'creator']) }}" class="btn btn-primary">
                            Kembali ke Halaman Creator
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 