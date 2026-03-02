#!/bin/zsh

# Script to create a GitHub repository and push code
# This assumes you have GitHub CLI (gh) installed

cd "$(dirname "$0")"

echo "🚀 Setting up GitHub repository for notch64-laravel"
echo ""

# Check if gh CLI is installed
if ! command -v gh &> /dev/null; then
    echo "⚠️  GitHub CLI (gh) is not installed."
    echo "Please install it first:"
    echo "  brew install gh"
    echo ""
    echo "After installing, run this script again."
    exit 1
fi

# Check if authenticated with GitHub
if ! gh auth status &> /dev/null; then
    echo "🔐 You need to authenticate with GitHub first..."
    gh auth login
fi

echo ""
echo "📝 Creating GitHub repository..."
echo ""

# Prompt for repository visibility
echo "Should this repository be public or private?"
echo "1) Private (recommended for personal projects)"
echo "2) Public"
read -r "choice?Enter choice (1 or 2): "

if [[ "$choice" == "2" ]]; then
    VISIBILITY="--public"
else
    VISIBILITY="--private"
fi

# Create the GitHub repository
gh repo create notch64-laravel $VISIBILITY --source=. --remote=origin

if [ $? -ne 0 ]; then
    echo "❌ Failed to create repository. It might already exist."
    echo "Checking if remote already exists..."

    if git remote get-url origin &> /dev/null; then
        echo "✅ Remote 'origin' already exists"
    else
        echo "Please create the repository manually on GitHub and run:"
        echo "  git remote add origin https://github.com/YOUR_USERNAME/notch64-laravel.git"
        exit 1
    fi
fi

echo ""
echo "📦 Preparing to push code..."
echo ""

# Check current branch name
CURRENT_BRANCH=$(git branch --show-current)
if [ -z "$CURRENT_BRANCH" ]; then
    echo "No commits yet. Creating initial commit..."
    git add .
    git commit -m "Initial commit: Laravel project setup with Notch64 branding"
    CURRENT_BRANCH="main"
fi

echo "Current branch: $CURRENT_BRANCH"
echo ""

# Push to GitHub
echo "🚀 Pushing to GitHub..."
git push -u origin $CURRENT_BRANCH

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Success! Your code has been pushed to GitHub!"
    echo ""
    echo "View your repository:"
    gh repo view --web
else
    echo ""
    echo "❌ Push failed. This might be because:"
    echo "  1. You need to commit your changes first"
    echo "  2. You need to resolve merge conflicts"
    echo "  3. The remote repository already has commits"
    echo ""
    echo "Try running:"
    echo "  git status"
    echo "  git add ."
    echo "  git commit -m 'Your commit message'"
    echo "  git push -u origin $CURRENT_BRANCH"
fi
