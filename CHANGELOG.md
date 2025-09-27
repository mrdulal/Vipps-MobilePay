# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Nothing yet

### Changed
- Nothing yet

### Fixed
- Nothing yet

## [1.2.2] - 2024-09-27

### Fixed
- **License Recognition**: Fixed corrupted LICENSE file that prevented GitHub from identifying the MIT license
- **GitHub Badges**: License badge now works properly with clean MIT license file
- **Open Source Status**: Repository is now properly recognized as MIT licensed open source project

### Changed
- Cleaned up LICENSE file format for better GitHub recognition
- Removed corrupted YAML frontmatter from license file

## [1.2.1] - 2024-09-27

### Fixed
- **GitHub Actions**: Fixed failing workflows by removing problematic Codecov integration
- **Dependencies**: Resolved composer.json validation issues
- **Testing**: Updated to Laravel 12 and PHPUnit 11 support

### Changed
- Simplified GitHub Actions coverage workflow
- Improved dependency management across workflows
- Updated test matrix to include Laravel 12

## [1.2.0] - 2024-09-27

### Added
- **GitHub Packages Support**: Complete integration with GitHub Packages registry
- **Dual Publishing**: Package now available on both Packagist and GitHub Packages
- **Installation Documentation**: Comprehensive guide for GitHub Packages installation
- **CI/CD Enhancement**: Automated GitHub Packages publishing workflow

### Changed
- Updated README with GitHub Packages installation instructions
- Enhanced workflow automation for package publishing

## [1.1.1] - 2024-09-27

### Fixed
- **GitHub Actions**: Updated release workflow permissions to fix "Resource not accessible" error
- **Modern Actions**: Migrated from deprecated actions/create-release to softprops/action-gh-release

### Changed
- Improved release workflow with better error handling
- Enhanced release notes formatting

## [1.1.0] - 2024-09-27

### Added
- **Laravel 12 Support**: Full compatibility with Laravel 12.x
- **PHPUnit 11**: Updated test suite to support PHPUnit 11
- **Extended Compatibility**: Support for Laravel 9, 10, 11, and 12

### Changed
- Updated version constraints in composer.json
- Enhanced test matrix in GitHub Actions workflows

## [1.0.0] - 2024-09-27

### Added
- 🏪 **MobilePay Vipps ePayment** - Standard payment method integration
- 🛒 **MobilePay Vipps Checkout** - Complete checkout solution with card payments  
- ⚡ **MobilePay Vipps Express** - Quick checkout from product pages with QR codes
- 🔄 **Recurring Payments** - Subscription and recurring payment support
- 📊 **Order Management API** - Capture, refund, cancel, and order management
- 🔗 **Webhook Support** - Handle payment status updates automatically with signature verification
- 📡 **Event-Driven Architecture** - Laravel events for all payment actions
- ✅ **Comprehensive Testing** - Full test suite with PHPUnit
- 🔧 **GitHub Actions CI/CD** - Automated testing across PHP 8.1-8.3 and Laravel 9-11
- 📚 **Complete Documentation** - Extensive README with examples and guides
- 🐳 **Docker Support** - Ready-to-use Docker configuration for development
- 🔒 **Security Features** - HMAC signature verification for webhooks
- 🌍 **Multi-Country Support** - Norway, Denmark, and Finland markets

### Technical Features
- Laravel 9, 10, 11 compatibility
- PHP 8.1, 8.2, 8.3 support
- PSR-12 coding standards
- Guzzle HTTP client integration
- Database migrations for payment storage
- Artisan commands for package management
- Service container integration
- Facade pattern implementation
- Event system integration
- Comprehensive error handling

[Unreleased]: https://github.com/mrdulal/Vipps-MobilePay/compare/v1.2.2...HEAD
[1.2.2]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.2.2
[1.2.1]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.2.1
[1.2.0]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.2.0
[1.1.1]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.1.1
[1.1.0]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.1.0
[1.0.0]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.0.0