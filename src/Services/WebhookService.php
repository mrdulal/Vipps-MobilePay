<?php

namespace Mrdulal\LaravelVipps\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mrdulal\LaravelVipps\Exceptions\VippsException;
use Mrdulal\LaravelVipps\Events\PaymentCompleted;
use Mrdulal\LaravelVipps\Events\PaymentCancelled;
use Mrdulal\LaravelVipps\Events\PaymentCaptured;
use Mrdulal\LaravelVipps\Events\PaymentRefunded;
use Mrdulal\LaravelVipps\Events\PaymentCreated;
use Mrdulal\LaravelVipps\Events\RecurringAgreementCreated;
use Mrdulal\LaravelVipps\Events\RecurringChargeCreated;

class WebhookService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Handle incoming webhook request.
     */
    public function handleWebhook(Request $request): array
    {
        $this->verifyWebhookSignature($request);

        $payload = $request->json()->all();
        
        if ($this->config['logging']['enabled']) {
            Log::info('Vipps webhook received', $payload);
        }

        $this->processWebhookEvent($payload);

        return ['status' => 'ok'];
    }

    /**
     * Verify webhook signature.
     */
    protected function verifyWebhookSignature(Request $request): void
    {
        if (!$this->config['webhook']['verify_signature']) {
            return;
        }

        $signature = $request->header('Authorization');
        $timestamp = $request->header('X-Timestamp');
        $body = $request->getContent();

        if (!$signature || !$timestamp) {
            throw new VippsException('Missing webhook signature or timestamp');
        }

        // Check timestamp tolerance
        $now = time();
        $webhookTime = (int) $timestamp;
        $tolerance = $this->config['webhook']['tolerance'] ?? 300;

        if (abs($now - $webhookTime) > $tolerance) {
            throw new VippsException('Webhook timestamp outside tolerance window');
        }

        // Verify signature
        $secret = $this->config['webhook']['secret'];
        if (!$secret) {
            throw new VippsException('Webhook secret not configured');
        }

        $expectedSignature = hash_hmac('sha256', $timestamp . $body, $secret);
        $providedSignature = str_replace('Bearer ', '', $signature);

        if (!hash_equals($expectedSignature, $providedSignature)) {
            throw new VippsException('Invalid webhook signature');
        }
    }

    /**
     * Process webhook event and fire appropriate Laravel events.
     */
    protected function processWebhookEvent(array $payload): void
    {
        $eventType = $payload['eventType'] ?? null;
        $transactionInfo = $payload['transactionInfo'] ?? [];
        $orderId = $transactionInfo['orderId'] ?? null;

        if (!$eventType || !$orderId) {
            if ($this->config['logging']['enabled']) {
                Log::warning('Invalid webhook payload received', $payload);
            }
            return;
        }

        switch ($eventType) {
            case 'RESERVE':
                event(new PaymentCreated($orderId, $payload));
                break;

            case 'SALE':
            case 'AUTHORIZED':
                event(new PaymentCompleted($orderId, $payload));
                break;

            case 'CANCEL':
            case 'CANCELLED':
                event(new PaymentCancelled($orderId, $payload));
                break;

            case 'CAPTURE':
            case 'CAPTURED':
                event(new PaymentCaptured($orderId, $payload));
                break;

            case 'REFUND':
            case 'REFUNDED':
                event(new PaymentRefunded($orderId, $payload));
                break;

            case 'RECURRING_AGREEMENT_CREATED':
                event(new RecurringAgreementCreated($orderId, $payload));
                break;

            case 'RECURRING_CHARGE_CREATED':
                event(new RecurringChargeCreated($orderId, $payload));
                break;

            default:
                if ($this->config['logging']['enabled']) {
                    Log::info('Unknown webhook event type: ' . $eventType, $payload);
                }
                break;
        }
    }

    /**
     * Create webhook URL for registration.
     */
    public function createWebhookUrl(string $baseUrl): string
    {
        return rtrim($baseUrl, '/') . '/vipps/webhook';
    }

    /**
     * Validate webhook configuration.
     */
    public function validateConfiguration(): array
    {
        $errors = [];

        if (empty($this->config['webhook']['secret'])) {
            $errors[] = 'Webhook secret is not configured';
        }

        if (!isset($this->config['webhook']['verify_signature'])) {
            $errors[] = 'Webhook signature verification setting is not configured';
        }

        if (!isset($this->config['webhook']['tolerance']) || !is_int($this->config['webhook']['tolerance'])) {
            $errors[] = 'Webhook tolerance is not properly configured';
        }

        return $errors;
    }
}