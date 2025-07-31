# 🚀 Panduan Setup Git & Push ke GitHub

## 📋 Masalah
Git tidak terinstall di sistem Windows Anda, sehingga tidak bisa melakukan push ke GitHub.

## 🔧 Solusi Lengkap

### **Step 1: Install Git**

#### **Opsi A: Download dari Website Resmi**
1. Buka: https://git-scm.com/download/win
2. Download Git for Windows
3. Install dengan default settings
4. Restart PowerShell/Command Prompt

#### **Opsi B: Install via Chocolatey (jika ada)**
```powershell
choco install git
```

#### **Opsi C: Install via Winget (Windows 10/11)**
```powershell
winget install --id Git.Git -e --source winget
```

### **Step 2: Verifikasi Install**
Setelah install, buka PowerShell baru dan cek:
```powershell
git --version
```

### **Step 3: Konfigurasi Git**
```powershell
# Set username dan email
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"

# Set default branch
git config --global init.defaultBranch main
```

### **Step 4: Setup Repository**

#### **Jika belum ada repository:**
```powershell
# Inisialisasi Git repository
git init

# Tambahkan remote origin
git remote add origin https://github.com/username/repository-name.git
```

#### **Jika sudah ada repository:**
```powershell
# Cek remote
git remote -v

# Jika belum ada remote, tambahkan
git remote add origin https://github.com/username/repository-name.git
```

### **Step 5: Authentication**

#### **Opsi A: Personal Access Token (Recommended)**
1. Buka GitHub → Settings → Developer settings → Personal access tokens
2. Generate new token (classic)
3. Pilih scopes: `repo`, `workflow`
4. Copy token
5. Gunakan token sebagai password saat push

#### **Opsi B: SSH Key**
```powershell
# Generate SSH key
ssh-keygen -t ed25519 -C "your.email@example.com"

# Add to SSH agent
ssh-add ~/.ssh/id_ed25519

# Copy public key
cat ~/.ssh/id_ed25519.pub
```
Lalu paste ke GitHub → Settings → SSH and GPG keys

### **Step 6: Push ke GitHub**

```powershell
# Cek status
git status

# Tambahkan semua file
git add .

# Commit perubahan
git commit -m "Fix Midtrans Snap.js issues and token generation"

# Push ke GitHub
git push -u origin main
```

## 🎯 Langkah Cepat untuk Project Ini

### **1. Install Git**
```powershell
# Download dan install dari https://git-scm.com/download/win
# Atau gunakan winget
winget install --id Git.Git -e --source winget
```

### **2. Setup Repository**
```powershell
# Buka PowerShell di folder project
cd C:\xampp\htdocs\omg.id-main

# Inisialisasi Git (jika belum)
git init

# Tambahkan remote (ganti dengan URL repository Anda)
git remote add origin https://github.com/username/omg.id-main.git
```

### **3. Commit dan Push**
```powershell
# Tambahkan semua file
git add .

# Commit dengan pesan yang jelas
git commit -m "Fix Midtrans Snap.js integration issues

- Fixed token generation (backend working perfectly)
- Removed duplicate snap.js inclusions
- Updated payment modal functionality
- Added comprehensive troubleshooting documentation
- Fixed SQL column issues (payment_status -> status)
- Removed alternative payment methods (Halaman option)
- Added test files for debugging"

# Push ke GitHub
git push -u origin main
```

## 🔍 Troubleshooting

### **Error: "git is not recognized"**
- Restart PowerShell setelah install Git
- Pastikan Git ada di PATH

### **Error: "Authentication failed"**
- Gunakan Personal Access Token sebagai password
- Atau setup SSH key

### **Error: "Repository not found"**
- Pastikan URL repository benar
- Pastikan Anda punya akses ke repository

### **Error: "Permission denied"**
- Pastikan Anda punya write access ke repository
- Check repository settings di GitHub

## 📝 File yang Akan Di-push

Berdasarkan perubahan yang telah dibuat:

### **✅ Files Modified:**
- `app/Src/Services/Eloquent/TransactionService.php`
- `app/Http/Controllers/Client/Product/ProductPurchaseWebhookController.php`
- `resources/views/products/product-payment-modal.blade.php`
- `resources/views/layouts/template-body.blade.php`
- `resources/views/products/card-product-public.blade.php`
- `routes/web.php`

### **✅ Files Created:**
- `public/test-snap-local.html`
- `public/test-modal-payment.html`
- `SNAP_LOCAL_TROUBLESHOOTING.md`
- `TOKEN_GENERATION_ANALYSIS.md`
- `ALTERNATIVE_PAYMENT_METHODS.md`

### **✅ Files Deleted:**
- `fix_midtrans_env.php`
- `test_token_generation.php`

## 🎯 Commit Message Suggestion

```bash
git commit -m "Fix Midtrans Snap.js integration and payment issues

Backend Changes:
- Fixed SQL column issues: payment_status -> status
- Updated TransactionService queries
- Fixed webhook controller payment status updates

Frontend Changes:
- Removed duplicate snap.js inclusions
- Fixed payment modal Snap.js loading
- Removed alternative payment methods (Halaman option)
- Updated product card payment buttons

Documentation:
- Added comprehensive troubleshooting guides
- Created test files for debugging
- Added token generation analysis

Testing:
- Backend token generation working perfectly
- Frontend needs browser testing
- All database queries fixed"
```

## 🚀 Quick Start Commands

Setelah Git terinstall:

```powershell
# 1. Setup
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"

# 2. Initialize (jika belum)
git init
git remote add origin https://github.com/username/omg.id-main.git

# 3. Add and commit
git add .
git commit -m "Fix Midtrans Snap.js integration issues"

# 4. Push
git push -u origin main
```

**Note**: Ganti `username` dan `repository-name` dengan URL repository GitHub Anda yang sebenarnya. 