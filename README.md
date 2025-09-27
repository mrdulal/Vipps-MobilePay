# Laravel MobilePay Vipps Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sushridad/laravel-vipps.svg?style=flat-square)](https://packagist.org/packages/sushridad/laravel-vipps)
[![Total Downloads](https://img.shields.io/packagist/dt/sushridad/laravel-vipps.svg?style=flat-square)](https://packagist.org/packages/sushridad/laravel-vipps)
[![License](https://img.shields.io/packagist/l/sushridad/laravel-vipps.svg?style=flat-square)](https://packagist.org/packages/sushridad/laravel-vipps)
[![PHP Version Require](https://img.shields.io/packagist/php-v/sushridad/laravel-vipps.svg?style=flat-square)](https://packagist.org/packages/sushridad/laravel-vipps)
[![Laravel Version](https://img.shields.io/badge/Laravel-9.0%2B-red.svg?style=flat-square)](https://laravel.com)
[![Tests](https://img.shields.io/github/actions/workflow/status/sushridad/laravel-vipps/tests.yml?label=tests&style=flat-square)](https://github.com/sushridad/laravel-vipps/actions)

A comprehensive Laravel package for MobilePay Vipps payment integration with support for all major Vipps payment methods. This package provides a clean, modern API for integrating with the Vipps MobilePay payment platform used across Norway, Denmark, and Finland.

## 🎯 Features

### Payment Methods
- **🏪 MobilePay Vipps ePayment** - Standard payment method integration
- **🛒 MobilePay Vipps Checkout** - Complete checkout solution with card payments
- **⚡ MobilePay Vipps Express** - Quick checkout from product pages with QR codes
- **🔄 Recurring Payments** - Subscription and recurring payment support

### Management & Operations  
- **📊 Order Management API** - Capture, refund, cancel, and order management
- **🔗 Webhook Support** - Handle payment status updates automatically with signature verification
- **📡 Event-Driven Architecture** - Laravel events for all payment actions
- **🛡️ Security** - Built-in signature verification and request validation

### Developer Experience
- **✅ Comprehensive Testing** - Full test suite with PHPUnit and Orchestra Testbench
- **📚 Type Safety** - Full type hints and PHPDoc annotations
- **🔧 Configurable** - Extensive configuration options
- **🐞 Debugging** - Built-in logging and error handling
- **📦 Laravel Integration** - Service providers, facades, and Artisan commands

## 🌍 Countries Supported

| Country | Service | Market Penetration | Users |
|---------|---------|-------------------|-------|
| **🇳🇴 Norway** | Vipps | 77% population | 4.2M users |
| **🇩🇰 Denmark** | MobilePay | 75% population | 4.4M users |
| **🇫🇮 Finland** | MobilePay | 50% population | 2.8M users |

> **Total Market Reach:** 11+ million active users across Nordic countries

## 📋 Requirements

| Requirement | Version | Notes |
|-------------|---------|-------|
| **PHP** | 8.1+ | Uses modern PHP features like enums, readonly properties |
| **Laravel** | 9.0+ | Compatible with Laravel 9, 10, and 11 |
| **Guzzle HTTP** | 7.0+ | For API communication |
| **ext-json** | * | JSON processing |
| **ext-openssl** | * | SSL/TLS support for API calls |

### Development Requirements
- **PHPUnit** 9.0+ or 10.0+
- **Orchestra Testbench** 7.0+, 8.0+, or 9.0+
- **Mockery** 1.4+ (for testing)

## 🚀 Installation

### 1. Install via Composer

```bash
composer require sushridad/laravel-vipps
```

### 2. Publish Configuration

```bash
# Publish configuration file
php artisan vendor:publish --provider="SushriDad\LaravelVipps\VippsServiceProvider" --tag="config"

# Publish migrations
php artisan vendor:publish --provider="SushriDad\LaravelVipps\VippsServiceProvider" --tag="migrations"

# Publish views (optional)
php artisan vendor:publish --provider="SushriDad\LaravelVipps\VippsServiceProvider" --tag="views"
```

### 3. Run Migrations

```bash
php artisan migrate
```

This will create the following tables:
- `vipps_payments` - Store payment records
- `vipps_recurring_agreements` - Store recurring payment agreements  
- `vipps_recurring_charges` - Store individual recurring charges

### 4. Laravel Auto-Discovery

The package uses Laravel's auto-discovery feature. The service provider and facade will be registered automatically.

**Manual Registration (if needed):**

```php
// config/app.php
'providers' => [
    // ...
    SushriDad\LaravelVipps\VippsServiceProvider::class,
],

'aliases' => [
    // ...
    'Vipps' => SushriDad\LaravelVipps\Facades\Vipps::class,
],
```

## ⚙️ Configuration

### Environment Variables

Add your Vipps credentials to your `.env` file:

```env
# Required: Basic Configuration
VIPPS_ENVIRONMENT=test                    # test or production
VIPPS_CLIENT_ID=your_client_id
VIPPS_CLIENT_SECRET=your_client_secret
VIPPS_SUBSCRIPTION_KEY=your_ocp_apim_subscription_key
VIPPS_MERCHANT_SERIAL_NUMBER=123456       # 6-digit MSN

# Required: Webhook Configuration
VIPPS_WEBHOOK_SECRET=your_webhook_secret

# Optional: Logging & Debugging
VIPPS_LOGGING_ENABLED=false
VIPPS_LOG_CHANNEL=default
VIPPS_LOG_LEVEL=info
```

### Configuration File

The package configuration is located at `config/vipps.php`. Key sections include:

```php
return [
    // Environment (test/production)
    'environment' => env('VIPPS_ENVIRONMENT', 'test'),
    
    // API Credentials
    'client_id' => env('VIPPS_CLIENT_ID'),
    'client_secret' => env('VIPPS_CLIENT_SECRET'),
    'subscription_key' => env('VIPPS_SUBSCRIPTION_KEY'),
    'merchant_serial_number' => env('VIPPS_MERCHANT_SERIAL_NUMBER'),
    
    // Feature toggles
    'features' => [
        'epayment' => true,
        'checkout' => true,
        'express' => true,
        'recurring' => true,
        'order_management' => true,
        'webhooks' => true,
    ],
    
    // HTTP client settings
    'http' => [
        'timeout' => 30,
        'connect_timeout' => 10,
        'verify' => true,
    ],
    
    // Express checkout UI settings
    'express' => [
        'button_theme' => 'orange',  // orange, white, white-outline
        'button_size' => 'large',    // small, medium, large
        'show_on_cart' => true,
        'show_on_product' => true,
    ],
];
```

## 🏁 Getting Started

### 1. Get Vipps MobilePay Account Keys

#### Step-by-Step Account Setup:

1. **Sign up** at [Vipps MobilePay Portal](https://portal.vippsmobilepay.com/)
2. **Wait for approval** (1-2 days) - you'll receive login details via email
3. **Access Developer Portal:**
   - Login to Vipps MobilePay Business Portal
   - Navigate to "Developer" tab
   - Select "Test Keys" for development or "Production Keys" for live environment
4. **Retrieve Credentials:**
   - **Merchant Serial Number (MSN)** - 6-digit number displayed prominently
   - **Client ID** - Click "Show keys" to reveal
   - **Client Secret** - Click "Show keys" to reveal  
   - **Subscription Key** - Listed as "Ocp-Apim-Subscription-Key"

#### Test vs Production

| Environment | Purpose | API Endpoint | Features |
|-------------|---------|--------------|----------|
| **Test** | Development & Testing | `https://apitest.vipps.no` | Full API access, test cards |
| **Production** | Live transactions | `https://api.vipps.no` | Real payments, KYC required |

### 2. Webhook Setup

Vipps requires a webhook endpoint for payment status updates:

```php
// routes/web.php or routes/api.php
Route::post('/vipps/webhook', [\SushriDad\LaravelVipps\Http\Controllers\WebhookController::class, 'handle']);
```

**Register your webhook URL in the Vipps portal:**
- Format: `https://yourdomain.com/vipps/webhook`
- Must be HTTPS in production
- Must respond with HTTP 200 for successful processing

### 3. Basic Usage

#### ePayment (Standard Payment)

```php
use SushriDad\LaravelVipps\Facades\Vipps;

// Create a payment
$payment = Vipps::ePayment()->create([
    'amount' => 10000, // Amount in øre (100.00 NOK)
    'currency' => 'NOK',
    'orderId' => 'order-123',
    'description' => 'Payment for order #123',
    'redirectUrl' => 'https://yoursite.com/payment/callback',
    'userFlow' => 'WEB_REDIRECT'
]);

// Get payment details
$details = Vipps::ePayment()->getPayment($payment['orderId']);

// Capture payment
$capture = Vipps::ePayment()->capture($payment['orderId'], [
    'amount' => 10000,
    'description' => 'Capture for order #123'
]);
```

#### Express Checkout

```php
use SushriDad\LaravelVipps\Facades\Vipps;

// Create express checkout session
$session = Vipps::express()->create([
    'amount' => 10000,
    'currency' => 'NOK',
    'orderId' => 'order-123',
    'description' => 'Express checkout for order #123',
    'redirectUrl' => 'https://yoursite.com/express/callback',
    'userInfo' => [
        'userId' => 'user-123'
    ]
]);

// Generate QR code for express checkout
$qrCode = Vipps::express()->generateQrCode([
    'orderId' => 'order-123',
    'amount' => 10000,
    'currency' => 'NOK',
    'description' => 'Product purchase',
    'redirectUrl' => 'https://yoursite.com/callback',
    'qrFormat' => 'SVG', // or 'PNG'
    'qrSize' => 300
]);

// Create shareable payment link
$shareableLink = Vipps::express()->createShareableLink([
    'orderId' => 'order-456',
    'amount' => 15000,
    'currency' => 'NOK',
    'description' => 'Shareable payment link',
    'redirectUrl' => 'https://yoursite.com/callback',
    'expiresAt' => now()->addHours(24)
]);
```

#### Recurring Payments

```php
use SushriDad\LaravelVipps\Facades\Vipps;

// Create recurring agreement
$agreement = Vipps::recurring()->createAgreement([
    'currency' => 'NOK',
    'price' => 9900, // 99.00 NOK
    'productName' => 'Monthly Subscription',
    'productDescription' => 'Premium subscription service',
    'merchantRedirectUrl' => 'https://yoursite.com/recurring/callback',
    'merchantAgreementUrl' => 'https://yoursite.com/agreement/123',
    'interval' => 'MONTH',
    'intervalCount' => 1,
    'isApp' => false
]);

// Create charge for agreement
$charge = Vipps::recurring()->createCharge($agreement['agreementId'], [
    'amount' => 9900,
    'currency' => 'NOK',
    'description' => 'Monthly subscription charge',
    'orderId' => 'charge-456'
]);

// List all charges for an agreement
$charges = Vipps::recurring()->listCharges($agreement['agreementId']);

// Stop an agreement
$result = Vipps::recurring()->stopAgreement($agreement['agreementId'], [
    'reason' => 'Customer requested cancellation'
]);
```

## 📚 API Reference

### Services Overview

| Service | Purpose | Key Methods |
|---------|---------|-------------|
| **ePayment** | Standard payments | `create()`, `capture()`, `refund()`, `cancel()` |
| **Express** | Quick checkout | `create()`, `generateQrCode()`, `createShareableLink()` |
| **Checkout** | Full checkout flow | `create()`, `updateSession()`, `getPaymentDetails()` |
| **Recurring** | Subscriptions | `createAgreement()`, `createCharge()`, `stopAgreement()` |
| **OrderManagement** | Payment operations | `capture()`, `refund()`, `cancel()`, `getPaymentHistory()` |
| **Webhook** | Event handling | `handleWebhook()`, `verifySignature()` |

### ePayment Service

#### Create Payment
```php
Vipps::ePayment()->create([
    'amount' => 10000,              // Required: Amount in øre (100.00 NOK)
    'currency' => 'NOK',            // Optional: NOK, DKK, EUR (default: NOK)
    'orderId' => 'order-123',       // Required: Unique order identifier
    'description' => 'Payment for order #123',  // Required: Payment description
    'redirectUrl' => 'https://yoursite.com/callback',  // Required: Callback URL
    'userFlow' => 'WEB_REDIRECT',   // Optional: WEB_REDIRECT, NATIVE_REDIRECT
    'paymentMethod' => 'WALLET',    // Optional: WALLET, CARD
    'skipLandingPage' => false,     // Optional: Skip Vipps landing page
    'userInfo' => [                 // Optional: Pre-fill user information
        'userId' => 'user-123',
        'mobileNumber' => '+4712345678',
        'email' => 'user@example.com'
    ],
    'reference' => 'ref-456'        // Optional: Your internal reference
]);
```

#### Capture Payment
```php
Vipps::ePayment()->capture('order-123', [
    'amount' => 10000,              // Required: Amount to capture
    'description' => 'Capture for order #123',  // Required
    'reference' => 'capture-ref'    // Optional
]);
```

#### Refund Payment
```php
Vipps::ePayment()->refund('order-123', [
    'amount' => 5000,               // Required: Amount to refund
    'description' => 'Partial refund',  // Required
    'reference' => 'refund-ref'     // Optional
]);
```

### Express Service

#### Generate QR Code
```php
Vipps::express()->generateQrCode([
    'orderId' => 'qr-order-123',
    'amount' => 15000,
    'currency' => 'NOK',
    'description' => 'QR Code Payment',
    'redirectUrl' => 'https://yoursite.com/callback',
    'qrFormat' => 'SVG',            // SVG or PNG
    'qrSize' => 300                 // Size in pixels (100-2000)
]);
```

#### Create Shareable Link
```php
Vipps::express()->createShareableLink([
    'orderId' => 'share-order-123',
    'amount' => 20000,
    'currency' => 'NOK',
    'description' => 'Shareable Payment Link',
    'redirectUrl' => 'https://yoursite.com/callback',
    'expiresAt' => now()->addDays(7)  // Optional: Link expiration
]);
```

### Recurring Service

#### Create Agreement
```php
Vipps::recurring()->createAgreement([
    'currency' => 'NOK',
    'price' => 9900,                // Monthly price in øre
    'productName' => 'Premium Plan', // Max 45 characters
    'productDescription' => 'Monthly premium subscription',  // Max 100 chars
    'merchantRedirectUrl' => 'https://yoursite.com/recurring/success',
    'merchantAgreementUrl' => 'https://yoursite.com/terms',
    'interval' => 'MONTH',          // WEEK, MONTH, YEAR
    'intervalCount' => 1,           // How many intervals between charges
    'isApp' => false,               // True if initiated from mobile app
    'phoneNumber' => '+4712345678', // Optional: Pre-fill phone
    'campaign' => [                 // Optional: Campaign pricing
        'start' => now(),
        'end' => now()->addMonths(3),
        'price' => 4900             // Campaign price in øre
    ]
]);
```

### Order Management Service

#### Get Payment History
```php
$history = Vipps::orderManagement()->getPaymentHistory('order-123');
// Returns array of all transactions for the order
```

#### Send Receipt
```php
Vipps::orderManagement()->sendReceipt('order-123', [
    'orderLines' => [
        [
            'name' => 'Premium Subscription',
            'id' => 'sub-001',
            'totalAmount' => 9900,
            'totalAmountExcludingTax' => 7920,
            'totalTaxAmount' => 1980,
            'taxRate' => 25.0,
            'unitInfo' => [
                'unitPrice' => 9900,
                'quantity' => '1',
                'quantityUnit' => 'month'
            ]
        ]
    ],
    'bottomLine' => [
        'currency' => 'NOK',
        'tipAmount' => 500,
        'barcode' => [
            'format' => 'EAN-13',
            'data' => '1234567890123'
        ]
    ]
]);
```

## 🔗 Webhook Handling

### Setup Webhook Route

```php
// routes/web.php or routes/api.php
Route::post('/vipps/webhook', [\SushriDad\LaravelVipps\Http\Controllers\WebhookController::class, 'handle']);
```

### Event Listeners

```php
// app/Providers/EventServiceProvider.php
use SushriDad\LaravelVipps\Events\{
    PaymentCompleted,
    PaymentCancelled,
    PaymentCaptured,
    PaymentRefunded,
    RecurringAgreementCreated,
    RecurringChargeCreated
};

protected $listen = [
    PaymentCompleted::class => [
        \App\Listeners\HandlePaymentCompleted::class,
    ],
    PaymentCancelled::class => [
        \App\Listeners\HandlePaymentCancelled::class,
    ],
    PaymentCaptured::class => [
        \App\Listeners\HandlePaymentCaptured::class,
    ],
    PaymentRefunded::class => [
        \App\Listeners\HandlePaymentRefunded::class,
    ],
    RecurringAgreementCreated::class => [
        \App\Listeners\HandleRecurringAgreementCreated::class,
    ],
    RecurringChargeCreated::class => [
        \App\Listeners\HandleRecurringChargeCreated::class,
    ],
];
```

### Event Listener Example

```php
<?php

namespace App\Listeners;

use SushriDad\LaravelVipps\Events\PaymentCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandlePaymentCompleted implements ShouldQueue
{
    public function handle(PaymentCompleted $event): void
    {
        $orderId = $event->orderId;
        $payload = $event->payload;
        
        // Update your order status
        $order = Order::where('order_id', $orderId)->first();
        if ($order) {
            $order->update(['status' => 'paid']);
            
            // Send confirmation email
            Mail::to($order->customer_email)->send(new PaymentConfirmation($order));
        }
    }
}
```

### Webhook Security

The package automatically verifies webhook signatures using HMAC-SHA256:

```php
// Webhook verification is automatic, but you can customize it
'webhook' => [
    'secret' => env('VIPPS_WEBHOOK_SECRET'),
    'tolerance' => 300,              // 5 minutes tolerance
    'verify_signature' => true,      // Enable signature verification
],
```

## 🎭 Events

The package fires Laravel events for all major payment actions:

| Event | Trigger | Payload |
|-------|---------|---------|
| `PaymentCreated` | Payment initiated | `orderId`, webhook `payload` |
| `PaymentCompleted` | Payment authorized/completed | `orderId`, webhook `payload` |
| `PaymentCancelled` | Payment cancelled | `orderId`, webhook `payload` |
| `PaymentCaptured` | Payment captured | `orderId`, webhook `payload` |
| `PaymentRefunded` | Payment refunded | `orderId`, webhook `payload` |
| `RecurringAgreementCreated` | Recurring agreement created | `agreementId`, webhook `payload` |
| `RecurringChargeCreated` | Recurring charge created | `chargeId`, webhook `payload` |

### Custom Event Handling

```php
// Listen to all Vipps events with a single listener
Event::listen('SushriDad\LaravelVipps\Events\*', function ($eventName, array $data) {
    $eventObject = $data[0];
    Log::info("Vipps event fired: {$eventName}", [
        'order_id' => $eventObject->orderId,
        'payload' => $eventObject->payload
    ]);
});
```

## 🧪 Testing

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage report
composer test-coverage

# Run specific test file
./vendor/bin/phpunit tests/Unit/VippsClientTest.php

# Run tests with verbose output
./vendor/bin/phpunit --verbose
```

### Writing Tests

The package provides a comprehensive test suite. Here's how to test your Vipps integration:

#### Mock Vipps Responses

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use SushriDad\LaravelVipps\Facades\Vipps;
use SushriDad\LaravelVipps\Services\VippsClient;
use Mockery;

class VippsPaymentTest extends TestCase
{
    public function test_can_create_payment()
    {
        // Mock the VippsClient
        $mockClient = Mockery::mock(VippsClient::class);
        $mockClient->shouldReceive('post')
            ->once()
            ->with('https://apitest.vipps.no/ecomm/v2/payments', Mockery::type('array'))
            ->andReturn([
                'orderId' => 'test-order-123',
                'url' => 'https://test.vipps.no/redirect-url',
                'token' => 'test-token'
            ]);

        $this->app->instance(VippsClient::class, $mockClient);

        // Test payment creation
        $response = Vipps::ePayment()->create([
            'amount' => 10000,
            'currency' => 'NOK',
            'orderId' => 'test-order-123',
            'description' => 'Test payment',
            'redirectUrl' => 'https://example.com/callback'
        ]);

        $this->assertEquals('test-order-123', $response['orderId']);
        $this->assertArrayHasKey('url', $response);
    }
}
```

#### Test Webhook Handling

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use SushriDad\LaravelVipps\Events\PaymentCompleted;
use Illuminate\Support\Facades\Event;

class WebhookTest extends TestCase
{
    public function test_payment_completed_webhook()
    {
        Event::fake();

        $payload = [
            'eventType' => 'SALE',
            'transactionInfo' => [
                'orderId' => 'test-order-123',
                'amount' => 10000,
                'status' => 'COMPLETED'
            ]
        ];

        $response = $this->postJson('/vipps/webhook', $payload);

        $response->assertStatus(200);
        Event::assertDispatched(PaymentCompleted::class);
    }
}
```

#### Test Environment Configuration

```php
// phpunit.xml
<phpunit>
    <php>
        <env name="VIPPS_ENVIRONMENT" value="test"/>
        <env name="VIPPS_CLIENT_ID" value="test_client_id"/>
        <env name="VIPPS_CLIENT_SECRET" value="test_client_secret"/>
        <env name="VIPPS_SUBSCRIPTION_KEY" value="test_subscription_key"/>
        <env name="VIPPS_MERCHANT_SERIAL_NUMBER" value="123456"/>
    </php>
</phpunit>
```

## Configuration Options

The package supports extensive configuration options. See `config/vipps.php` for all available options including:

- API endpoints and timeouts
- Webhook configuration
- Logging settings
- Default payment parameters
- Error handling options

## Order Management

The package includes comprehensive order management capabilities:

```php
// Capture partial amount
$capture = Vipps::orderManagement()->capture('order-123', [
    'amount' => 5000, // Partial capture
    'description' => 'Partial shipment'
]);

// Refund payment
$refund = Vipps::orderManagement()->refund('order-123', [
    'amount' => 2000,
    'description' => 'Product return'
]);

// Cancel payment
$cancel = Vipps::orderManagement()->cancel('order-123', [
    'description' => 'Order cancelled by customer'
]);

// Get payment history
$history = Vipps::orderManagement()->getPaymentHistory('order-123');
```

## Error Handling

The package provides comprehensive error handling:

```php
use SushriDad\LaravelVipps\Exceptions\VippsException;
use SushriDad\LaravelVipps\Exceptions\VippsValidationException;
use SushriDad\LaravelVipps\Exceptions\VippsApiException;

try {
    $payment = Vipps::ePayment()->create($paymentData);
} catch (VippsValidationException $e) {
    // Handle validation errors
    $errors = $e->getValidationErrors();
} catch (VippsApiException $e) {
    // Handle API errors
    $apiError = $e->getApiError();
} catch (VippsException $e) {
    // Handle general Vipps errors
    $message = $e->getMessage();
}
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review our security policy on how to report security vulnerabilities.

## Credits

- [Sushri Dad](https://github.com/sushridad)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Links

- [Vipps MobilePay Developer Documentation](https://developer.vippsmobilepay.com/)
- [Vipps MobilePay Portal](https://portal.vippsmobilepay.com/)
- [Laravel Package Development](https://laravel.com/docs/packages)