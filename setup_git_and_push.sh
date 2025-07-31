#!/bin/bash

# Script untuk setup Git dan push ke GitHub
echo "=== GIT SETUP AND PUSH TO GITHUB ==="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# 1. Check if Git is installed
echo -e "${YELLOW}1. Checking Git installation...${NC}"
if command -v git &> /dev/null; then
    git_version=$(git --version)
    echo -e "${GREEN}✅ Git is installed: $git_version${NC}"
else
    echo -e "${RED}❌ Git is not installed.${NC}"
    echo "Please install Git manually from https://git-scm.com/"
    echo "Or run: sudo apt-get install git (Ubuntu/Debian)"
    echo "Or run: brew install git (macOS)"
    exit 1
fi

# 2. Configure Git (if not already configured)
echo -e "\n${YELLOW}2. Configuring Git...${NC}"

# Check if Git is configured
user_name=$(git config --global user.name 2>/dev/null)
user_email=$(git config --global user.email 2>/dev/null)

if [ -z "$user_name" ]; then
    echo -e "${YELLOW}Setting up Git username...${NC}"
    read -p "Enter your name for Git commits: " name
    git config --global user.name "$name"
fi

if [ -z "$user_email" ]; then
    echo -e "${YELLOW}Setting up Git email...${NC}"
    read -p "Enter your email for Git commits: " email
    git config --global user.email "$email"
fi

echo -e "${GREEN}✅ Git configuration completed!${NC}"

# 3. Check current Git status
echo -e "\n${YELLOW}3. Checking Git repository status...${NC}"

if [ -d ".git" ]; then
    echo -e "${GREEN}✅ Git repository found!${NC}"
    
    # Check status
    if [ -n "$(git status --porcelain)" ]; then
        echo -e "${YELLOW}📝 Changes detected:${NC}"
        git status --short
    else
        echo -e "${GREEN}✅ No changes to commit${NC}"
    fi
    
    # Check remote
    remote_url=$(git remote get-url origin 2>/dev/null)
    if [ -n "$remote_url" ]; then
        echo -e "${GREEN}✅ Remote repository: $remote_url${NC}"
    else
        echo -e "${RED}❌ No remote repository configured${NC}"
        read -p "Enter your GitHub repository URL (e.g., https://github.com/username/repo.git): " repo_url
        git remote add origin "$repo_url"
        echo -e "${GREEN}✅ Remote repository added!${NC}"
    fi
else
    echo -e "${RED}❌ Not a Git repository. Initializing...${NC}"
    git init
    echo -e "${GREEN}✅ Git repository initialized!${NC}"
    
    read -p "Enter your GitHub repository URL (e.g., https://github.com/username/repo.git): " repo_url
    git remote add origin "$repo_url"
    echo -e "${GREEN}✅ Remote repository added!${NC}"
fi

# 4. Add and commit changes
echo -e "\n${YELLOW}4. Adding and committing changes...${NC}"

# Add all files
git add .
echo -e "${GREEN}✅ Files added to staging area${NC}"

# Commit changes
read -p "Enter commit message (or press Enter for default: 'Update email system and payment features'): " commit_message
if [ -z "$commit_message" ]; then
    commit_message="Update email system and payment features"
fi

git commit -m "$commit_message"
echo -e "${GREEN}✅ Changes committed!${NC}"

# 5. Push to GitHub
echo -e "\n${YELLOW}5. Pushing to GitHub...${NC}"

# Check if main branch exists
current_branch=$(git branch --show-current 2>/dev/null)
if [ -z "$current_branch" ]; then
    echo -e "${YELLOW}Creating main branch...${NC}"
    git checkout -b main
fi

# Push to GitHub
if git push -u origin main; then
    echo -e "${GREEN}✅ Successfully pushed to GitHub!${NC}"
else
    echo -e "${RED}❌ Failed to push to GitHub.${NC}"
    echo -e "\n${YELLOW}Troubleshooting tips:${NC}"
    echo "1. Make sure you have access to the repository"
    echo "2. Check your GitHub credentials"
    echo "3. Try: git push -u origin main --force (if needed)"
    echo "4. If using HTTPS, you might need to enter your GitHub username and Personal Access Token"
fi

echo -e "\n${GREEN}=== GIT SETUP COMPLETED ===${NC}"
echo -e "${GREEN}Check your GitHub repository to see the changes!${NC}" 