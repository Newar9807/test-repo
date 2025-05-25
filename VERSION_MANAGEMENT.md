# Automated Version Management System

This repository implements an automated version management system that increments the plugin version whenever the `next` branch is merged into `main`.

## How It Works

### 1. Plugin Structure
- **File**: `test-repo.php`
- **Current Version**: 1.0.0
- **Version Locations**: The version is stored in three places:
  - Plugin header: `Version: 1.0.0`
  - PHP constant: `define('TEST_REPO_VERSION', '1.0.0')`
  - Class constant: `const VERSION = '1.0.0'`

### 2. GitHub Actions Workflow
- **File**: `.github/workflows/version-increment.yml`
- **Trigger**: When a pull request from `next` branch is merged into `main`
- **Action**: Automatically increments the patch version (third digit)

### 3. Version Increment Logic
- **Format**: MAJOR.MINOR.PATCH (e.g., 1.0.0)
- **Increment**: Only the PATCH number is incremented
- **Example**: 1.0.0 → 1.0.1 → 1.0.2 → 1.0.3

## Workflow Process

1. **Development**: Make changes in the `next` branch
2. **Pull Request**: Create a PR from `next` to `main`
3. **Merge**: When the PR is merged, the GitHub Action triggers
4. **Version Update**: The action:
   - Extracts the current version from `test-repo.php`
   - Increments the patch version
   - Updates all version references in the file
   - Commits the changes to both `main` and `next` branches
   - Creates a Git tag (e.g., `v1.0.1`)
   - Creates a GitHub release

## Testing the System

To test the automated version increment:

1. Make a change in the `next` branch:
   ```bash
   git checkout next
   # Make some changes to any file
   git add .
   git commit -m "Test change"
   git push origin next
   ```

2. Create a pull request from `next` to `main` on GitHub

3. Merge the pull request

4. The GitHub Action will automatically:
   - Increment version from 1.0.0 to 1.0.1
   - Update `test-repo.php` with the new version
   - Create a release tag `v1.0.1`

## Plugin Features

The `test-repo.php` file includes:
- Standard WordPress plugin header
- Singleton pattern implementation
- Admin menu integration
- Activation/deactivation hooks
- Uninstall cleanup
- Translation support
- Security measures (direct access prevention)

## File Structure

```
test-repo/
├── .github/
│   └── workflows/
│       └── version-increment.yml
├── test-repo.php
├── README.txt
└── VERSION_MANAGEMENT.md
```

## Version History

- **1.0.0**: Initial version with basic plugin structure and automated versioning system 