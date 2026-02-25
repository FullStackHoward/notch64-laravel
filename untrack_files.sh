#!/bin/zsh

# Remove files from git tracking that should be ignored
# These files will remain on your filesystem but won't be tracked by git

cd "$(dirname "$0")"

echo "Removing gitignored files from git tracking..."

# Remove .env file from tracking
if git ls-files --error-unmatch .env > /dev/null 2>&1; then
    git rm --cached .env
    echo "✓ Removed .env from tracking"
fi

# Remove laravel.log and all log files from tracking
git ls-files | grep 'storage/logs/.*\.log$' | while read file; do
    git rm --cached "$file" 2>/dev/null && echo "✓ Removed $file from tracking"
done

# Remove .idea directory from tracking
if git ls-files .idea > /dev/null 2>&1; then
    git rm -r --cached .idea 2>/dev/null
    echo "✓ Removed .idea/ directory from tracking"
fi

# Remove vendor directory from tracking (if tracked)
if git ls-files vendor > /dev/null 2>&1; then
    git rm -r --cached vendor 2>/dev/null
    echo "✓ Removed vendor/ directory from tracking"
fi

# Remove storage/framework/views compiled views
echo "Removing storage/framework/views compiled files..."
git ls-files | grep 'storage/framework/views/.*\.php$' | while read file; do
    git rm --cached "$file" 2>/dev/null
done
echo "✓ Removed storage/framework/views compiled files from tracking"

# Remove storage/framework/cache files (not .gitignore)
echo "Removing storage/framework/cache files..."
git ls-files | grep 'storage/framework/cache/' | grep -v '\.gitignore$' | while read file; do
    git rm --cached "$file" 2>/dev/null
done

# Remove storage/framework/sessions files (not .gitignore)
echo "Removing storage/framework/sessions files..."
git ls-files | grep 'storage/framework/sessions/' | grep -v '\.gitignore$' | while read file; do
    git rm --cached "$file" 2>/dev/null
done

# Remove storage/framework/testing files (not .gitignore)
echo "Removing storage/framework/testing files..."
git ls-files | grep 'storage/framework/testing/' | grep -v '\.gitignore$' | while read file; do
    git rm --cached "$file" 2>/dev/null
done

# Remove bootstrap/cache files (not .gitignore)
echo "Removing bootstrap/cache files..."
git ls-files | grep 'bootstrap/cache/' | grep -v '\.gitignore$' | while read file; do
    git rm --cached "$file" 2>/dev/null
done
echo "✓ Removed bootstrap/cache files from tracking"

# Remove database/*.sqlite files
git ls-files | grep 'database/.*\.sqlite' | while read file; do
    git rm --cached "$file" 2>/dev/null && echo "✓ Removed $file from tracking"
done

# Remove storage/app files (except .gitignore)
echo "Removing storage/app files..."
git ls-files | grep 'storage/app/' | grep -v '\.gitignore$' | while read file; do
    # Skip if it's just the directory structure
    if [[ "$file" != "storage/app/public/" && "$file" != "storage/app/private/" ]]; then
        git rm --cached "$file" 2>/dev/null
    fi
done

echo ""
echo "✅ Done! Files have been removed from git tracking but remain on your filesystem."
echo ""
echo "Next step: Commit these changes with:"
echo "  git commit -m 'Remove gitignored files from tracking'"
