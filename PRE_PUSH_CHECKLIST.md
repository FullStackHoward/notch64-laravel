# ✅ Pre-Push Checklist

Before pushing your code to GitHub, make sure:

## 🔒 Security Checks

- [ ] `.env` file is NOT being tracked
  ```bash
  git ls-files | grep "^.env$"  # Should return nothing
  ```

- [ ] No sensitive data in tracked files (passwords, API keys, tokens)

- [ ] Database file is NOT being tracked
  ```bash
  git ls-files | grep ".sqlite"  # Should return nothing
  ```

## 🧹 Cleanup Checks

- [ ] Run the cleanup script to remove gitignored files from tracking:
  ```bash
  chmod +x untrack_files.sh && ./untrack_files.sh
  ```

- [ ] Verify no compiled views are tracked:
  ```bash
  git ls-files | grep "storage/framework/views/.*\.php$"  # Should return nothing
  ```

- [ ] Verify no log files are tracked:
  ```bash
  git ls-files | grep "\.log$"  # Should return nothing
  ```

## 📝 Documentation Checks

- [ ] README.md is updated with project-specific information ✅ (Done)
- [ ] .env.example contains appropriate defaults ✅ (Done)
- [ ] config/notch64.php has correct links ✅ (Done)

## 🔧 Configuration Checks

- [ ] All links in home.blade.php reference config file ✅ (Done)
  ```bash
  grep -n "config('notch64" resources/views/home.blade.php  # Should see multiple matches
  ```

- [ ] No hardcoded URLs remain in blade templates
  ```bash
  grep -E "https?://" resources/views/home.blade.php | grep -v "config\|asset\|fonts.googleapis\|googletagmanager"
  ```

## 🚀 Ready to Push?

If all checks pass, run:

```bash
chmod +x complete_github_setup.sh
./complete_github_setup.sh
```

Or manually:

```bash
# 1. Add and commit
git add .
git commit -m "Initial commit: Notch64 Laravel website"

# 2. Create repo (with GitHub CLI)
gh repo create notch64-laravel --private --source=. --remote=origin

# 3. Push
git push -u origin main
```

---

## 🎯 Quick Verification Commands

Run these to verify your repo is clean:

```bash
# Check what will be committed
git status

# See what files are tracked
git ls-files

# Verify .env is ignored
git check-ignore .env  # Should output: .env

# Verify vendor is ignored
git check-ignore vendor  # Should output: vendor

# Check for any sensitive patterns
git ls-files | grep -E "\.(env|sqlite|log)$"  # Should return nothing or only .env.example
```

---

## ✨ Post-Push Verification

After pushing:

1. [ ] Visit your GitHub repository
2. [ ] Verify .env is NOT there
3. [ ] Verify vendor/ is NOT there
4. [ ] Verify README.md displays correctly
5. [ ] Check that all necessary files are present (app/, config/, public/, etc.)

---

## 🆘 Problems?

If something is tracked that shouldn't be:

```bash
# Remove specific file from tracking
git rm --cached path/to/file

# Remove directory from tracking
git rm -r --cached path/to/directory

# Commit the removal
git commit -m "Remove ignored files from tracking"

# Push the update
git push
```
