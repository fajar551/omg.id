# 🔧 Troubleshooting Payment Snap Issue

## 📋 Masalah
Payment snap untuk produk tidak muncul meskipun URL sudah berubah.

## 🔍 Analisis Masalah

### **Root Cause yang Mungkin:**
1. **Snap.js tidak di-load dengan benar** di modal product payment
2. **Timing issue** - snap.js belum selesai loading saat modal dibuka
3. **Environment variables** tidak ter-load dengan benar
4. **Cache browser** atau Laravel cache

## 🚀 Solusi yang Sudah Diterapkan

### **1. Memperbaiki Script Loading di Modal**
File: `resources/views/products/product-payment-modal.blade.php`

```html
<!-- Midtrans Snap.js Script -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
```

### **2. Memperbaiki JavaScript Logic**
- ✅ Menambahkan function `checkSnapAvailability()`
- ✅ Meningkatkan retry attempts dari 3 ke 5
- ✅ Meningkatkan delay retry dari 1000ms ke 2000ms
- ✅ Menambahkan debug logging yang lebih detail

### **3. File Test yang Dibuat**
- ✅ `public/test-product-snap.html` - Test lengkap dengan AJAX
- ✅ `public/test-snap-simple.html` - Test sederhana snap.js

## 🔧 Langkah Troubleshooting

### **Step 1: Test Snap.js After Reload**
1. Buka: `http://localhost/omg.id-main/public/test-reload-snap.html`
2. Klik tombol "Reload Page" beberapa kali
3. Setiap reload, klik "Check Snap Status"
4. Jika status selalu "✅ Snap.js loaded successfully" = snap.js berfungsi
5. Jika status "❌ Snap.js is NOT loaded" = ada masalah dengan loading

### **Step 2: Test Snap.js Basic**
1. Buka: `http://localhost/omg.id-main/public/test-snap-simple.html`
2. Klik tombol "Test Snap"
3. Jika popup muncul = snap.js berfungsi
4. Jika tidak muncul = ada masalah dengan snap.js

### **Step 2: Test Product Payment**
1. Buka halaman creator
2. Buka Developer Tools (F12)
3. Pilih tab Console
4. Coba beli produk
5. Periksa log untuk error

### **Step 3: Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### **Step 4: Check Environment Variables**
Pastikan file `.env` memiliki:
```env
MIDTRANS_CLIENT_KEY=SB-Mid-client-yXcEzjhVAqWaf3qm
MIDTRANS_SERVER_KEY=SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA
APP_ENV=local
```

## 🐛 Debug Steps

### **1. Console Log Check**
Buka browser console dan cari:
```
✅ Snap is available in modal
✅ Snap is available, calling snap.pay...
✅ snap.pay called successfully
```

### **2. Network Tab Check**
1. Buka Developer Tools
2. Pilih tab Network
3. Coba beli produk
4. Cari request ke `/api/product/payment/process`
5. Periksa response untuk `snap_token`

### **3. Snap.js Loading Check**
Di console, ketik:
```javascript
console.log('Snap available:', typeof snap !== 'undefined');
console.log('Snap object:', snap);
console.log('Snap.pay function:', typeof snap.pay);
```

## 🔄 Alternative Solutions

### **Solution 1: Load Snap.js di Layout (SUDAH DITERAPKAN)**
✅ Menambahkan snap.js di layout utama:
```html
<!-- Di layouts/template-body.blade.php -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yXcEzjhVAqWaf3qm"></script>
```

### **Solution 2: Dynamic Loading (SUDAH DITERAPKAN)**
✅ Load snap.js secara dinamis saat modal dibuka:
```javascript
function loadSnapJS() {
    if (typeof snap === 'undefined') {
        var script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', 'SB-Mid-client-yXcEzjhVAqWaf3qm');
        document.head.appendChild(script);
    }
}
```

### **Solution 3: Modal Event Listener (SUDAH DITERAPKAN)**
✅ Pastikan modal dibuka dengan benar:
```javascript
$('#productPaymentModal').on('shown.bs.modal', function() {
    console.log('Modal shown, ensuring Snap is available...');
    loadSnapJS();
    setTimeout(checkSnapAvailability, 500);
});
```

### **Solution 2: Dynamic Loading**
Load snap.js secara dinamis saat modal dibuka:
```javascript
function loadSnapJS() {
    if (typeof snap === 'undefined') {
        var script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', 'SB-Mid-client-yXcEzjhVAqWaf3qm');
        document.head.appendChild(script);
    }
}
```

### **Solution 3: Check Modal Trigger**
Pastikan modal dibuka dengan benar:
```javascript
$('#productPaymentModal').on('shown.bs.modal', function() {
    console.log('Modal shown, checking snap...');
    setTimeout(checkSnapAvailability, 500);
});
```

## 🚨 Masalah Duplicate Snap.js (SUDAH DIPERBAIKI)

### **Gejala:**
- Snap.js tidak muncul setelah reload halaman
- Modal payment terbuka tapi snap popup tidak muncul
- Console menampilkan "Snap is not available"
- Konflik JavaScript karena multiple snap.js

### **Penyebab:**
1. **Duplicate Snap.js**: snap.js di-load di multiple tempat
   - Layout `template-body.blade.php` (2x)
   - Layout `template-support.blade.php`
   - Modal `product-payment-modal.blade.php`
2. **Timing Issue**: snap.js belum selesai loading saat modal dibuka
3. **Cache Browser**: browser cache script lama

### **Solusi yang Diterapkan:**
1. ✅ **Hapus duplicate snap.js** dari `template-body.blade.php`
2. ✅ **Hapus snap.js dari modal** - sudah tersedia di layout
3. ✅ **Hapus dynamic loading** - tidak diperlukan lagi
4. ✅ **Clear Laravel cache** - memastikan perubahan ter-apply

### **Test Reload:**
1. Buka: `http://localhost/omg.id-main/public/test-reload-snap.html`
2. Klik "Reload Page" beberapa kali
3. Setiap reload, klik "Check Snap Status"
4. Pastikan status selalu "✅ Snap.js loaded successfully"

## 📞 Support

Jika masalah masih berlanjut:
1. Periksa browser console untuk error
2. Test dengan file `test-reload-snap.html`
3. Pastikan tidak ada ad blocker yang memblokir Midtrans
4. Coba di browser berbeda (Chrome, Firefox, Safari)
5. Clear browser cache (Ctrl+Shift+R) 