<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Produk - Midtrans</title>
</head>
<body>
    @if($token)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                snap.pay("{{ $token }}", {
                    onSuccess: function(result){
                        window.location.href = '/'; // redirect ke halaman sukses
                    },
                    onPending: function(result){
                        window.location.href = '/'; // redirect ke halaman pending
                    },
                    onError: function(result){
                        alert('Pembayaran gagal!');
                    },
                    onClose: function(){
                        // User menutup popup
                    }
                });
            });
        </script>
        <p>Memuat pembayaran Midtrans...</p>
    @else
        <p>Gagal mendapatkan token pembayaran. Silakan coba lagi.</p>
    @endif
</body>
</html> 