# Changelog

All notable changes to `laravel-vipps` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial release of Laravel MobilePay Vipps package
- MobilePay Vipps ePayment integration
- MobilePay Vipps Checkout support
- MobilePay Vipps Express checkout
- Recurring payments functionality
- Order Management API integration
- Comprehensive webhook handling
- Event-driven architecture with Laravel events
- Full test suite with PHPUnit
- Extensive configuration options
- Multi-environment support (test/production)
- Database migrations for payment tracking
- Blade view for express checkout button
- Comprehensive error handling and validation
- PSR-12 compliant codebase
- Full documentation and examples

### Features
- **ePayment Service**: Create, capture, refund, and cancel payments
- **Express Service**: Quick checkout with QR codes and shareable links
- **Checkout Service**: Complete checkout solution with card payments
- **Recurring Service**: Subscription and recurring payment management
- **Order Management**: Advanced payment lifecycle management
- **Webhook Service**: Automatic payment status updates
- **Events**: Laravel events for all payment actions
- **Validation**: Comprehensive input validation for all API calls
- **Logging**: Configurable logging for debugging and monitoring
- **Caching**: Access token caching for improved performance

### Supported Countries
- Norway (Vipps) - 77% population usage
- Denmark (MobilePay) - 75% population usage  
- Finland (MobilePay) - 50% population usage

### Requirements
- PHP 8.1 or higher
- Laravel 9.0 or higher
- Guzzle HTTP client 7.0 or higher

## [1.0.0] - 2024-XX-XX

### Added
- Initial stable release