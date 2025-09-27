# Badge Status Check

This file helps verify that all badges in the README are working correctly.

## Current Badge URLs

1. **Packagist Version**: `https://img.shields.io/packagist/v/mrdulal/laravel-vipps.svg`
2. **Downloads**: `https://img.shields.io/packagist/dt/mrdulal/laravel-vipps.svg`
3. **License**: `https://img.shields.io/github/license/mrdulal/Vipps-MobilePay.svg`
4. **PHP Version**: `https://img.shields.io/packagist/php-v/mrdulal/laravel-vipps.svg`
5. **Laravel Support**: `https://img.shields.io/badge/Laravel-9%2B-orange.svg` (static)
6. **Tests**: `https://img.shields.io/github/actions/workflow/status/mrdulal/Vipps-MobilePay/tests.yml`

## Expected Status After Fixes

- ✅ **License**: Should show "MIT" (fixed clean LICENSE file)
- ✅ **Tests**: Should show "passing" (GitHub Actions workflow running)
- ⏳ **Packagist Version**: Will show version after Packagist submission
- ⏳ **Downloads**: Will show count after Packagist submission
- ✅ **PHP Version**: Will work after Packagist submission
- ✅ **Laravel Support**: Static badge (always works)

## GitHub Actions Status

- Repository: `mrdulal/Vipps-MobilePay`
- Workflow file: `.github/workflows/tests.yml`
- Should be triggered by push to main branch
- Tests multiple PHP versions (8.1, 8.2, 8.3) and Laravel versions (9, 10, 11)

## Next Steps

1. Monitor GitHub Actions to ensure tests pass
2. Submit package to Packagist to fix package-related badges
3. Verify all badges display correctly after submission

## Debug URLs

If badges still show errors, check these URLs directly:

- License API: `https://api.github.com/repos/mrdulal/Vipps-MobilePay`
- Actions API: `https://api.github.com/repos/mrdulal/Vipps-MobilePay/actions/workflows`
- Packagist API: `https://packagist.org/packages/mrdulal/laravel-vipps.json`