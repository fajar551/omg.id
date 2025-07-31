# Script untuk setup Git dan push ke GitHub
Write-Host "=== GIT SETUP AND PUSH TO GITHUB ===" -ForegroundColor Green

# 1. Check if Git is installed
Write-Host "1. Checking Git installation..." -ForegroundColor Yellow
try {
    $gitVersion = git --version
    Write-Host "✅ Git is installed: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Git is not installed. Installing Git..." -ForegroundColor Red
    
    # Install Git using winget
    try {
        Write-Host "Installing Git using winget..." -ForegroundColor Yellow
        winget install --id Git.Git -e --source winget
        Write-Host "✅ Git installed successfully!" -ForegroundColor Green
        
        # Refresh environment variables
        $env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")
        
        # Wait a moment for installation to complete
        Start-Sleep -Seconds 5
    } catch {
        Write-Host "❌ Failed to install Git using winget. Please install Git manually from https://git-scm.com/" -ForegroundColor Red
        exit 1
    }
}

# 2. Configure Git (if not already configured)
Write-Host "`n2. Configuring Git..." -ForegroundColor Yellow

# Check if Git is configured
$userName = git config --global user.name 2>$null
$userEmail = git config --global user.email 2>$null

if (-not $userName) {
    Write-Host "Setting up Git username..." -ForegroundColor Yellow
    $name = Read-Host "Enter your name for Git commits"
    git config --global user.name $name
}

if (-not $userEmail) {
    Write-Host "Setting up Git email..." -ForegroundColor Yellow
    $email = Read-Host "Enter your email for Git commits"
    git config --global user.email $email
}

Write-Host "✅ Git configuration completed!" -ForegroundColor Green

# 3. Check current Git status
Write-Host "`n3. Checking Git repository status..." -ForegroundColor Yellow

if (Test-Path ".git") {
    Write-Host "✅ Git repository found!" -ForegroundColor Green
    
    # Check status
    $status = git status --porcelain
    if ($status) {
        Write-Host "📝 Changes detected:" -ForegroundColor Yellow
        git status --short
    } else {
        Write-Host "✅ No changes to commit" -ForegroundColor Green
    }
    
    # Check remote
    $remote = git remote get-url origin 2>$null
    if ($remote) {
        Write-Host "✅ Remote repository: $remote" -ForegroundColor Green
    } else {
        Write-Host "❌ No remote repository configured" -ForegroundColor Red
        $repoUrl = Read-Host "Enter your GitHub repository URL (e.g., https://github.com/username/repo.git)"
        git remote add origin $repoUrl
        Write-Host "✅ Remote repository added!" -ForegroundColor Green
    }
} else {
    Write-Host "❌ Not a Git repository. Initializing..." -ForegroundColor Red
    git init
    Write-Host "✅ Git repository initialized!" -ForegroundColor Green
    
    $repoUrl = Read-Host "Enter your GitHub repository URL (e.g., https://github.com/username/repo.git)"
    git remote add origin $repoUrl
    Write-Host "✅ Remote repository added!" -ForegroundColor Green
}

# 4. Add and commit changes
Write-Host "`n4. Adding and committing changes..." -ForegroundColor Yellow

# Add all files
git add .
Write-Host "✅ Files added to staging area" -ForegroundColor Green

# Commit changes
$commitMessage = Read-Host "Enter commit message (or press Enter for default: 'Update email system and payment features')"
if (-not $commitMessage) {
    $commitMessage = "Update email system and payment features"
}

git commit -m $commitMessage
Write-Host "✅ Changes committed!" -ForegroundColor Green

# 5. Push to GitHub
Write-Host "`n5. Pushing to GitHub..." -ForegroundColor Yellow

try {
    # Check if main branch exists
    $currentBranch = git branch --show-current
    if (-not $currentBranch) {
        Write-Host "Creating main branch..." -ForegroundColor Yellow
        git checkout -b main
    }
    
    # Push to GitHub
    git push -u origin main
    Write-Host "✅ Successfully pushed to GitHub!" -ForegroundColor Green
    
} catch {
    Write-Host "❌ Failed to push to GitHub. Error: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "`nTroubleshooting tips:" -ForegroundColor Yellow
    Write-Host "1. Make sure you have access to the repository" -ForegroundColor White
    Write-Host "2. Check your GitHub credentials" -ForegroundColor White
    Write-Host "3. Try: git push -u origin main --force (if needed)" -ForegroundColor White
}

Write-Host "`n=== GIT SETUP COMPLETED ===" -ForegroundColor Green
Write-Host "Check your GitHub repository to see the changes!" -ForegroundColor Cyan 