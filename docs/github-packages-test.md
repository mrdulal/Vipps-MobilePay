# GitHub Packages Test Installation

This directory contains a test to verify GitHub Packages installation works correctly.

## Test Installation

1. Create a test Laravel project:
```bash
composer create-project laravel/laravel github-packages-test
cd github-packages-test
```

2. Add GitHub Packages repository to composer.json:
```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://composer.github.com/mrdulal/Vipps-MobilePay"
        }
    ]
}
```

3. Configure GitHub authentication:
```bash
composer config github-oauth.github.com YOUR_GITHUB_TOKEN
```

4. Install the package:
```bash
composer require mrdulal/laravel-vipps
```

5. Verify installation:
```bash
composer show mrdulal/laravel-vipps
```

## Expected Output

You should see package information similar to:
```
name     : mrdulal/laravel-vipps
descrip. : Laravel package for MobilePay Vipps payment integration
keywords : laravel, vipps, mobilepay, payment, checkout, express, recurring, subscription
versions : * v1.2.0
type     : library
license  : MIT
homepage : https://github.com/mrdulal/Vipps-MobilePay
source   : [git] https://github.com/mrdulal/Vipps-MobilePay.git
```

## Cleanup

```bash
cd ..
rm -rf github-packages-test
```