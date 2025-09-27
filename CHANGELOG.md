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

[Unreleased]: https://github.com/mrdulal/Vipps-MobilePay/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/mrdulal/Vipps-MobilePay/releases/tag/v1.0.0