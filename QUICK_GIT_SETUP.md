# 🚀 Quick Git Setup untuk Push ke GitHub

## 📋 Masalah
Git tidak terinstall, sehingga tidak bisa push ke GitHub.

## 🔧 Solusi Cepat

### **Step 1: Install Git**
1. **Download Git**: https://git-scm.com/download/win
2. **Install** dengan default settings
3. **Restart PowerShell** setelah install

### **Step 2: Setup Repository**
Buka PowerShell di folder project dan jalankan:

```powershell
# Konfigurasi Git
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"

# Inisialisasi repository (jika belum ada)
git init

# Tambahkan remote (ganti dengan URL repository Anda)
git remote add origin https://github.com/username/omg.id-main.git
```

### **Step 3: Push ke GitHub**
```powershell
# Tambahkan semua file
git add .

# Commit perubahan
git commit -m "Fix Midtrans Snap.js integration issues"

# Push ke GitHub
git push -u origin main
```

## 🔐 Authentication

### **Personal Access Token (Recommended)**
1. Buka GitHub → Settings → Developer settings → Personal access tokens
2. Generate new token (classic)
3. Pilih scopes: `repo`, `workflow`
4. Copy token
5. Gunakan token sebagai **password** saat push

### **Username & Password**
- **Username**: GitHub username Anda
- **Password**: Personal Access Token (bukan password GitHub)

## 🎯 Langkah Manual

### **1. Install Git**
- Download dari: https://git-scm.com/download/win
- Install dengan default settings
- Restart PowerShell

### **2. Buka PowerShell di Project Folder**
```powershell
cd C:\xampp\htdocs\omg.id-main
```

### **3. Setup Git**
```powershell
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"
```

### **4. Initialize Repository**
```powershell
git init
git remote add origin https://github.com/username/omg.id-main.git
```

### **5. Add & Commit**
```powershell
git add .
git commit -m "Fix Midtrans Snap.js integration issues"
```

### **6. Push**
```powershell
git push -u origin main
```

## 📝 File yang Akan Di-push

### **✅ Modified Files:**
- `app/Src/Services/Eloquent/TransactionService.php`
- `app/Http/Controllers/Client/Product/ProductPurchaseWebhookController.php`
- `resources/views/products/product-payment-modal.blade.php`
- `resources/views/layouts/template-body.blade.php`
- `resources/views/products/card-product-public.blade.php`
- `routes/web.php`

### **✅ New Files:**
- `public/test-snap-local.html`
- `public/test-modal-payment.html`
- `SNAP_LOCAL_TROUBLESHOOTING.md`
- `TOKEN_GENERATION_ANALYSIS.md`
- `ALTERNATIVE_PAYMENT_METHODS.md`
- `GIT_SETUP_GUIDE.md`
- `QUICK_GIT_SETUP.md`
- `setup_git_and_push.ps1`

## 🔍 Troubleshooting

### **"git is not recognized"**
- Restart PowerShell setelah install Git
- Pastikan Git ada di PATH

### **"Authentication failed"**
- Gunakan Personal Access Token sebagai password
- Bukan password GitHub biasa

### **"Repository not found"**
- Pastikan URL repository benar
- Pastikan Anda punya akses ke repository

## 🚀 Quick Commands

Setelah Git terinstall:

```powershell
# Setup
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"

# Initialize
git init
git remote add origin https://github.com/username/omg.id-main.git

# Add & Commit
git add .
git commit -m "Fix Midtrans Snap.js integration issues"

# Push
git push -u origin main
```

**Note**: Ganti `username` dengan username GitHub Anda yang sebenarnya. 