<?php

namespace Mrdulal\LaravelVipps\Services;

use Mrdulal\LaravelVipps\Exceptions\VippsValidationException;
use Illuminate\Support\Facades\Validator;

class EPaymentService
{
    protected VippsClient $client;

    public function __construct(VippsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new ePayment.
     */
    public function create(array $data): array
    {
        $this->validateCreateData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments';

        $payload = [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NOK',
            'orderId' => $data['orderId'],
            'description' => $data['description'],
            'redirectUrl' => $data['redirectUrl'],
            'userFlow' => $data['userFlow'] ?? 'WEB_REDIRECT',
            'paymentMethod' => $data['paymentMethod'] ?? 'WALLET',
            'skipLandingPage' => $data['skipLandingPage'] ?? false,
        ];

        if (isset($data['userInfo'])) {
            $payload['userInfo'] = $data['userInfo'];
        }

        if (isset($data['reference'])) {
            $payload['reference'] = $data['reference'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Get payment details.
     */
    public function getPayment(string $orderId): array
    {
        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId;
        return $this->client->get($endpoint);
    }

    /**
     * Cancel a payment.
     */
    public function cancel(string $orderId, array $data = []): array
    {
        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId . '/cancel';
        
        $payload = [
            'description' => $data['description'] ?? 'Payment cancelled',
        ];

        return $this->client->put($endpoint, $payload);
    }

    /**
     * Capture a payment.
     */
    public function capture(string $orderId, array $data): array
    {
        $this->validateCaptureData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId . '/capture';
        
        $payload = [
            'amount' => $data['amount'],
            'description' => $data['description'],
        ];

        if (isset($data['reference'])) {
            $payload['reference'] = $data['reference'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Refund a payment.
     */
    public function refund(string $orderId, array $data): array
    {
        $this->validateRefundData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId . '/refund';
        
        $payload = [
            'amount' => $data['amount'],
            'description' => $data['description'],
        ];

        if (isset($data['reference'])) {
            $payload['reference'] = $data['reference'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Get payment event log.
     */
    public function getEventLog(string $orderId): array
    {
        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId . '/events';
        return $this->client->get($endpoint);
    }

    /**
     * Validate create payment data.
     */
    protected function validateCreateData(array $data): void
    {
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:100|max:99999999',
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'orderId' => 'required|string|max:50',
            'description' => 'required|string|max:100',
            'redirectUrl' => 'required|url',
            'userFlow' => 'sometimes|string|in:WEB_REDIRECT,NATIVE_REDIRECT',
            'paymentMethod' => 'sometimes|string|in:WALLET,CARD',
            'skipLandingPage' => 'sometimes|boolean',
            'userInfo.userId' => 'sometimes|string',
            'userInfo.mobileNumber' => 'sometimes|string',
            'userInfo.email' => 'sometimes|email',
            'reference' => 'sometimes|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for ePayment creation',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate capture data.
     */
    protected function validateCaptureData(array $data): void
    {
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:100|max:99999999',
            'description' => 'required|string|max:100',
            'reference' => 'sometimes|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for payment capture',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate refund data.
     */
    protected function validateRefundData(array $data): void
    {
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:100|max:99999999',
            'description' => 'required|string|max:100',
            'reference' => 'sometimes|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for payment refund',
                $validator->errors()->toArray()
            );
        }
    }
}