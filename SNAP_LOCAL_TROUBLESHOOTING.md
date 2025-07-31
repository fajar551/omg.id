# 🔧 Troubleshooting Snap.js di Local Environment

## 📋 Masalah
Snap Midtrans tidak muncul di environment local (localhost).

## 🔍 Analisis Penyebab

### **1. Konfigurasi Environment**
- ✅ **MIDTRANS_CLIENT_KEY** - Sudah terkonfigurasi
- ✅ **MIDTRANS_SERVER_KEY** - Sudah terkonfigurasi
- ✅ **APP_ENV=local** - Sudah terkonfigurasi

### **2. Kemungkinan Penyebab**
1. **Network Issues** - Tidak bisa akses Midtrans domain
2. **Ad Blocker** - Browser memblokir Midtrans
3. **HTTPS Issues** - Local menggunakan HTTP, Midtrans butuh HTTPS
4. **Script Loading** - Snap.js tidak ter-load dengan benar
5. **Browser Issues** - Browser tidak support atau ada cache

## 🚀 Langkah Troubleshooting

### **Step 1: Test Snap.js Basic**
1. Buka: `http://localhost/omg.id-main/public/test-snap-local.html`
2. Periksa status Snap.js
3. Test network connectivity
4. Lihat console log untuk error

### **Step 2: Check Browser Console**
1. Buka Developer Tools (F12)
2. Pilih tab Console
3. Cari error yang terkait dengan:
   - `snap.js`
   - `midtrans`
   - `CORS`
   - `Mixed Content`

### **Step 3: Test Network Connectivity**
```bash
# Test koneksi ke Midtrans
curl -I https://app.sandbox.midtrans.com/snap/snap.js
```

### **Step 4: Check Environment Variables**
```bash
# Pastikan konfigurasi benar
php artisan config:show midtrans
```

## 🛠️ Solusi yang Diterapkan

### **1. ✅ Konfigurasi Environment**
```env
# Midtrans Configuration
MIDTRANS_MERCHANT_ID=G123456789
MIDTRANS_CLIENT_KEY=SB-Mid-client-yXcEzjhVAqWaf3qm
MIDTRANS_SERVER_KEY=SB-Mid-server-GwUP_WGbJPXsDzsNEBRs8IYA
APP_ENV=local
```

### **2. ✅ Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### **3. ✅ Test File**
File test: `public/test-snap-local.html`
- Test Snap.js loading
- Test network connectivity
- Test popup functionality

## 🔧 Solusi untuk Masalah Spesifik

### **Masalah 1: Snap.js Tidak Load**
**Gejala**: `snap is not defined`

**Solusi**:
1. **Disable Ad Blocker** untuk localhost
2. **Check Network** - pastikan bisa akses Midtrans
3. **Clear Browser Cache** - Ctrl+Shift+R
4. **Try Different Browser** - Chrome, Firefox, Safari

### **Masalah 2: Mixed Content Error**
**Gejala**: `Mixed Content: The page was loaded over HTTPS, but requested an insecure resource`

**Solusi**:
1. **Use HTTPS locally** dengan ngrok atau similar
2. **Disable HTTPS requirement** di browser (temporary)
3. **Use localhost** bukan IP address

### **Masalah 3: CORS Error**
**Gejala**: `CORS policy: No 'Access-Control-Allow-Origin' header`

**Solusi**:
1. **Check Laravel CORS config**
2. **Add Midtrans domain** ke allowed origins
3. **Use proper headers** di request

### **Masalah 4: Token Generation Failed**
**Gejala**: `Failed to generate snap token`

**Solusi**:
1. **Check server key** - pastikan benar
2. **Check request format** - pastikan data lengkap
3. **Check Laravel logs** - lihat error detail

## 📱 Test di Browser Berbeda

### **Chrome**
1. Buka Developer Tools
2. Disable ad blocker untuk localhost
3. Clear cache dan cookies
4. Test dengan incognito mode

### **Firefox**
1. Buka Developer Tools
2. Disable tracking protection untuk localhost
3. Clear cache dan cookies
4. Test dengan private browsing

### **Safari**
1. Buka Developer Tools
2. Disable content blockers
3. Clear cache dan cookies
4. Test dengan private browsing

## 🌐 Network Troubleshooting

### **Test Connectivity**
```bash
# Test Midtrans domain
ping app.sandbox.midtrans.com

# Test HTTPS connection
curl -I https://app.sandbox.midtrans.com/snap/snap.js

# Test DNS resolution
nslookup app.sandbox.midtrans.com
```

### **Firewall Issues**
1. **Check Windows Firewall** - allow localhost
2. **Check Antivirus** - disable temporarily
3. **Check Corporate Firewall** - if applicable

## 🔍 Debug Steps

### **1. Browser Console Check**
```javascript
// Check if snap is available
console.log('Snap available:', typeof snap !== 'undefined');
console.log('Snap object:', snap);
console.log('Snap.pay function:', typeof snap.pay);
```

### **2. Network Tab Check**
1. Buka Developer Tools
2. Pilih tab Network
3. Reload halaman
4. Cari request ke `snap.js`
5. Periksa response status

### **3. Laravel Log Check**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check specific errors
grep -i "midtrans\|snap" storage/logs/laravel.log
```

## 🚨 Common Issues & Solutions

### **Issue 1: "Snap is not defined"**
**Cause**: Script tidak ter-load
**Solution**: 
- Check network connectivity
- Disable ad blocker
- Clear browser cache

### **Issue 2: "Token generation failed"**
**Cause**: Server key salah atau request invalid
**Solution**:
- Check MIDTRANS_SERVER_KEY
- Validate request data
- Check Laravel logs

### **Issue 3: "Popup not showing"**
**Cause**: Browser blocking popup
**Solution**:
- Allow popup for localhost
- Check browser settings
- Try different browser

### **Issue 4: "CORS error"**
**Cause**: Cross-origin request blocked
**Solution**:
- Configure CORS in Laravel
- Use proper headers
- Check domain configuration

## 📞 Support

Jika masalah masih berlanjut:

1. **Check test file**: `http://localhost/omg.id-main/public/test-snap-local.html`
2. **Check browser console** untuk error detail
3. **Check Laravel logs** untuk backend errors
4. **Test di browser berbeda**
5. **Check network connectivity**

## 🔮 Alternative Solutions

### **1. Use ngrok for HTTPS**
```bash
# Install ngrok
npm install -g ngrok

# Start tunnel
ngrok http 8000

# Use HTTPS URL
https://abc123.ngrok.io
```

### **2. Use Local HTTPS**
```bash
# Generate SSL certificate
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout localhost.key -out localhost.crt

# Configure web server for HTTPS
```

### **3. Use Different Payment Method**
- Implement manual payment flow
- Use redirect payment instead of popup
- Implement webhook-based payment 