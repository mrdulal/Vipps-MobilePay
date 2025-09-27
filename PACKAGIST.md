# Publishing to Packagist

This guide explains how to publish the Laravel MobilePay Vipps package to Packagist.

## Prerequisites

1. ✅ GitHub repository is public and accessible
2. ✅ Package has proper `composer.json` with all required fields
3. ✅ Package has proper licensing (MIT)
4. ✅ Package has been tagged with a version (v1.0.0)
5. ✅ Tests are passing on CI/CD
6. ✅ Documentation is complete

## Steps to Publish

### 1. Verify Package Structure

```bash
# Validate composer.json
composer validate --strict

# Run tests
composer test

# Check autoload
composer dump-autoload
```

### 2. Submit to Packagist

1. Go to [Packagist.org](https://packagist.org/)
2. Sign in with your GitHub account
4. Go to "Submit" (https://packagist.org/packages/submit)
5. Enter your repository URL: `https://github.com/mrdulal/Vipps-MobilePay`
6. Click "Check"
7. If validation passes, click "Submit"

### 3. Package Information

- **Package Name**: `mrdulal/laravel-vipps`
- **Repository**: `https://github.com/mrdulal/Vipps-MobilePay`
- **Latest Version**: `v1.0.0`
- **License**: MIT
- **PHP Version**: ^8.1
- **Laravel Version**: ^9.0|^10.0|^11.0

### 4. Auto-Update Setup

After submitting, you can set up automatic updates:

1. Go to your package page on Packagist
2. Click "Settings"  
3. Enable "GitHub Service Hook" or "GitHub Auto-Update"
4. This will automatically update Packagist when you push new tags

### 5. Verification

Once published, verify:

- Package appears on Packagist: https://packagist.org/packages/mrdulal/laravel-vipps
- Badges in README.md show correct information
- Installation works: `composer require mrdulal/laravel-vipps`

## Expected Results

After successful publication:

- ✅ Packagist badge will show "v1.0.0"
- ✅ Downloads badge will show download count
- ✅ License badge will show "MIT"
- ✅ PHP Version badge will show "^8.1"
- ✅ Package will be installable via Composer

## Next Release

For future releases:

1. Update `CHANGELOG.md`
2. Create new tag: `git tag -a v1.0.1 -m "Release v1.0.1"`
3. Push tag: `git push origin v1.0.1`
4. Packagist will auto-update (if webhook is configured)
5. GitHub Actions will create the release automatically

## Troubleshooting

If submission fails:
- Check composer.json validation
- Ensure repository is public
- Verify all required files exist (README, LICENSE, composer.json)
- Check that tests pass
- Ensure proper tagging with semantic versioning