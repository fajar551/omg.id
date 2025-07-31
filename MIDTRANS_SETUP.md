# 🚀 Setup Midtrans Payment Gateway

## 📋 Prerequisites

Sebelum mengaktifkan Midtrans, pastikan Anda memiliki:

1. **Akun Midtrans** - Daftar di [Midtrans Dashboard](https://dashboard.midtrans.com/)
2. **Merchant ID** - Dapatkan dari dashboard Midtrans
3. **Client Key & Server Key** - Untuk sandbox dan production
4. **Domain yang sudah terdaftar** - Untuk webhook dan redirect

## 🔧 Konfigurasi Environment Variables

Tambahkan konfigurasi berikut di file `.env`:

```env
# Midtrans Configuration
MIDTRANS_MERCHAT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_PAYOUT_KEY=your_payout_key
MIDTRANS_PAYOUT_URL=your_payout_url
MIDTRANS_APPROVE_KEY=your_approve_key
```

### 🔑 Cara Mendapatkan Keys:

1. **Login ke Midtrans Dashboard**
2. **Pilih Environment** (Sandbox/Production)
3. **Settings > Access Keys**
4. **Copy Client Key dan Server Key**

## 🗄️ Database Setup

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=PaymentMethodSeeder
```

Ini akan menambahkan payment methods Midtrans ke database.

## 🌐 Webhook Configuration

### 1. Webhook URL
Tambahkan webhook URL berikut di Midtrans Dashboard:

```
https://yourdomain.com/api/webhook/midtrans
```

### 2. Webhook Events
Pastikan events berikut diaktifkan:
- `payment_success`
- `payment_pending`
- `payment_failed`
- `payment_expired`

## 🧪 Testing

### 1. Test Configuration
Jalankan script test untuk mengecek konfigurasi:

```bash
php test_midtrans_config.php
```

### 2. Test Payment Flow
1. **Buka halaman support** di aplikasi
2. **Pilih payment method Midtrans**
3. **Isi form payment**
4. **Klik "Pay"**
5. **Verifikasi popup Midtrans muncul**

## 📱 Payment Methods yang Tersedia

### Midtrans Core API:
- ✅ **Credit Card**
- ✅ **Bank Transfer** (BCA, BNI, BRI, Mandiri)
- ✅ **Gopay**
- ✅ **OVO**
- ✅ **Dana**
- ✅ **LinkAja**
- ✅ **ShopeePay**
- ✅ **QRIS**

## 🔄 Payment Flow

### 1. **Frontend Flow:**
```
User Input → Validation → getSnapToken() → Midtrans Popup → Payment → Callback
```

### 2. **Backend Flow:**
```
getSnapToken() → Store Temp Data → User Payment → Webhook → Process Payment → Update Database
```

## 🛠️ Troubleshooting

### Common Issues:

#### 1. **"Client key not found"**
- ✅ Cek `MIDTRANS_CLIENT_KEY` di `.env`
- ✅ Pastikan key benar (sandbox/production)

#### 2. **"Invalid signature"**
- ✅ Cek `MIDTRANS_SERVER_KEY` di `.env`
- ✅ Pastikan webhook URL benar

#### 3. **"Payment method not found"**
- ✅ Jalankan seeder: `php artisan db:seed --class=PaymentMethodSeeder`
- ✅ Cek tabel `payment_methods`

#### 4. **"Snap token error"**
- ✅ Cek semua environment variables
- ✅ Pastikan domain terdaftar di Midtrans

## 📊 Monitoring

### 1. **Log Files**
Cek log Laravel untuk error:
```bash
tail -f storage/logs/laravel.log
```

### 2. **Midtrans Dashboard**
- Monitor transaksi di dashboard Midtrans
- Cek webhook delivery status
- Review payment analytics

## 🔒 Security Best Practices

### 1. **Environment Variables**
- ✅ Jangan commit `.env` ke repository
- ✅ Gunakan different keys untuk sandbox/production
- ✅ Rotate keys secara berkala

### 2. **Webhook Security**
- ✅ Verifikasi signature di webhook
- ✅ Gunakan HTTPS untuk webhook URL
- ✅ Implement rate limiting

### 3. **Data Protection**
- ✅ Enkripsi sensitive data
- ✅ Implement proper logging
- ✅ Regular security audit

## 📞 Support

Jika mengalami masalah:

1. **Cek dokumentasi Midtrans**: [Midtrans Docs](https://docs.midtrans.com/)
2. **Cek log Laravel** untuk error details
3. **Test dengan sandbox** sebelum production
4. **Hubungi Midtrans Support** jika diperlukan

---

**Status**: ✅ Ready untuk Production
**Last Updated**: $(date)
**Version**: 1.0 