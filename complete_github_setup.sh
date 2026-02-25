#!/bin/zsh

# Complete GitHub Setup Script for Notch64 Laravel Project
# This script will:
# 1. Remove gitignored files from tracking
# 2. Create a GitHub repository
# 3. Push your code

cd "$(dirname "$0")"

echo "╔═══════════════════════════════════════════════╗"
echo "║   Notch64 Laravel - GitHub Setup Script      ║"
echo "╚═══════════════════════════════════════════════╝"
echo ""

# Step 1: Remove gitignored files from tracking
echo "📋 Step 1/3: Cleaning up tracked files that should be ignored..."
echo ""

if [ -f "untrack_files.sh" ]; then
    chmod +x untrack_files.sh
    ./untrack_files.sh

    if [ $? -eq 0 ]; then
        echo ""
        echo "✅ Cleanup complete!"
    else
        echo "⚠️  Some files couldn't be cleaned up, but continuing..."
    fi
else
    echo "⚠️  untrack_files.sh not found, skipping cleanup..."
fi

echo ""
echo "─────────────────────────────────────────────"
echo ""

# Step 2: Check git status
echo "📋 Step 2/3: Checking git status..."
echo ""

# Check if there are changes to commit
if [[ -n $(git status -s) ]]; then
    echo "📝 Changes detected. Adding and committing files..."
    git add .
    git commit -m "Initial commit: Notch64 Laravel website with config-driven links"

    if [ $? -eq 0 ]; then
        echo "✅ Changes committed successfully!"
    else
        echo "⚠️  Commit failed or no changes to commit"
    fi
else
    echo "✅ Working directory is clean, no changes to commit"
fi

echo ""
echo "─────────────────────────────────────────────"
echo ""

# Step 3: Create GitHub repo and push
echo "📋 Step 3/3: Creating GitHub repository and pushing code..."
echo ""

# Check if gh CLI is installed
if ! command -v gh &> /dev/null; then
    echo "⚠️  GitHub CLI (gh) is not installed."
    echo ""
    echo "Option 1: Install GitHub CLI (recommended):"
    echo "  brew install gh"
    echo "  Then run this script again"
    echo ""
    echo "Option 2: Manual setup:"
    echo "  1. Go to https://github.com/new"
    echo "  2. Create a repository named 'notch64-laravel'"
    echo "  3. Run these commands:"
    echo "     git remote add origin https://github.com/YOUR_USERNAME/notch64-laravel.git"
    echo "     git branch -M main"
    echo "     git push -u origin main"
    echo ""
    exit 1
fi

# Check if authenticated
if ! gh auth status &> /dev/null; then
    echo "🔐 Authenticating with GitHub..."
    gh auth login
fi

# Check if remote already exists
if git remote get-url origin &> /dev/null; then
    echo "✅ Remote 'origin' already exists"
    REMOTE_URL=$(git remote get-url origin)
    echo "   URL: $REMOTE_URL"
    echo ""
    echo "Pushing to existing remote..."
else
    # Prompt for repository visibility
    echo "Should this repository be public or private?"
    echo "1) Private (recommended)"
    echo "2) Public"
    read -r "choice?Enter choice (1 or 2): "

    if [[ "$choice" == "2" ]]; then
        VISIBILITY="--public"
        echo "Creating public repository..."
    else
        VISIBILITY="--private"
        echo "Creating private repository..."
    fi

    # Create the GitHub repository
    gh repo create notch64-laravel $VISIBILITY --source=. --remote=origin --description="Personal website for Notch64 - The Wonderful Works of Notch64"

    if [ $? -ne 0 ]; then
        echo "❌ Failed to create repository"
        exit 1
    fi

    echo "✅ Repository created!"
fi

echo ""

# Get current branch
CURRENT_BRANCH=$(git branch --show-current)
if [ -z "$CURRENT_BRANCH" ]; then
    CURRENT_BRANCH="main"
fi

# Push to GitHub
echo "🚀 Pushing to GitHub (branch: $CURRENT_BRANCH)..."
git push -u origin $CURRENT_BRANCH

if [ $? -eq 0 ]; then
    echo ""
    echo "╔═══════════════════════════════════════════════╗"
    echo "║            🎉 SUCCESS! 🎉                     ║"
    echo "╚═══════════════════════════════════════════════╝"
    echo ""
    echo "Your code has been pushed to GitHub!"
    echo ""
    echo "🌐 View your repository:"
    gh repo view --web
else
    echo ""
    echo "❌ Push failed. Possible reasons:"
    echo "  • Remote repository has commits that you don't have locally"
    echo "  • Authentication issue"
    echo "  • Network problem"
    echo ""
    echo "Try:"
    echo "  git pull origin $CURRENT_BRANCH --rebase"
    echo "  git push -u origin $CURRENT_BRANCH"
    exit 1
fi

echo ""
echo "📝 Next steps:"
echo "  • Configure repository settings on GitHub if needed"
echo "  • Set up GitHub Pages (if you want to host it)"
echo "  • Add collaborators (Settings → Collaborators)"
echo ""
echo "✨ Happy coding!"
