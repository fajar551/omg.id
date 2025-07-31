# PowerShell Script untuk Setup Git dan Push ke GitHub
# Jalankan script ini di PowerShell dengan Administrator privileges

Write-Host "🚀 Setup Git dan Push ke GitHub" -ForegroundColor Green
Write-Host "=================================" -ForegroundColor Green

# Step 1: Check if Git is installed
Write-Host "`n📋 Step 1: Checking Git installation..." -ForegroundColor Yellow

try {
    $gitVersion = git --version 2>$null
    if ($gitVersion) {
        Write-Host "✅ Git is installed: $gitVersion" -ForegroundColor Green
    } else {
        Write-Host "❌ Git not found in PATH" -ForegroundColor Red
        Write-Host "   Installing Git via winget..." -ForegroundColor Yellow
        winget install --id Git.Git -e --source winget
        Write-Host "   Please restart PowerShell and run this script again" -ForegroundColor Yellow
        exit
    }
} catch {
    Write-Host "❌ Git not installed" -ForegroundColor Red
    Write-Host "   Please install Git from: https://git-scm.com/download/win" -ForegroundColor Yellow
    exit
}

# Step 2: Configure Git
Write-Host "`n📋 Step 2: Configuring Git..." -ForegroundColor Yellow

$userName = Read-Host "Enter your name for Git configuration"
$userEmail = Read-Host "Enter your email for Git configuration"

git config --global user.name $userName
git config --global user.email $userEmail
git config --global init.defaultBranch main

Write-Host "✅ Git configured successfully" -ForegroundColor Green

# Step 3: Initialize Git repository
Write-Host "`n📋 Step 3: Initializing Git repository..." -ForegroundColor Yellow

if (!(Test-Path ".git")) {
    git init
    Write-Host "✅ Git repository initialized" -ForegroundColor Green
} else {
    Write-Host "✅ Git repository already exists" -ForegroundColor Green
}

# Step 4: Add remote origin
Write-Host "`n📋 Step 4: Adding remote origin..." -ForegroundColor Yellow

$repoUrl = Read-Host "Enter your GitHub repository URL (e.g., https://github.com/username/repo-name.git)"

# Remove existing remote if exists
git remote remove origin 2>$null

# Add new remote
git remote add origin $repoUrl

Write-Host "✅ Remote origin added: $repoUrl" -ForegroundColor Green

# Step 5: Add all files
Write-Host "`n📋 Step 5: Adding files to Git..." -ForegroundColor Yellow

git add .
Write-Host "✅ All files added to staging area" -ForegroundColor Green

# Step 6: Commit changes
Write-Host "`n📋 Step 6: Committing changes..." -ForegroundColor Yellow

$commitMessage = @"
Fix Midtrans Snap.js integration and payment issues

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
- All database queries fixed
"@

git commit -m $commitMessage
Write-Host "✅ Changes committed successfully" -ForegroundColor Green

# Step 7: Push to GitHub
Write-Host "`n📋 Step 7: Pushing to GitHub..." -ForegroundColor Yellow

Write-Host "⚠️  You will be prompted for GitHub credentials" -ForegroundColor Yellow
Write-Host "   Username: Your GitHub username" -ForegroundColor Cyan
Write-Host "   Password: Use Personal Access Token (not your GitHub password)" -ForegroundColor Cyan

git push -u origin main

Write-Host "`n🎉 Setup completed!" -ForegroundColor Green
Write-Host "=================================" -ForegroundColor Green
Write-Host "✅ Git installed and configured" -ForegroundColor Green
Write-Host "✅ Repository initialized" -ForegroundColor Green
Write-Host "✅ Remote origin added" -ForegroundColor Green
Write-Host "✅ Files committed" -ForegroundColor Green
Write-Host "✅ Pushed to GitHub" -ForegroundColor Green

Write-Host "`n📝 Next steps:" -ForegroundColor Yellow
Write-Host "1. Check your GitHub repository" -ForegroundColor Cyan
Write-Host "2. Verify all files are uploaded" -ForegroundColor Cyan
Write-Host "3. Test the application" -ForegroundColor Cyan

Write-Host "`n🔗 Useful commands:" -ForegroundColor Yellow
Write-Host "git status          - Check repository status" -ForegroundColor Cyan
Write-Host "git log --oneline   - View commit history" -ForegroundColor Cyan
Write-Host "git remote -v       - Check remote repositories" -ForegroundColor Cyan 