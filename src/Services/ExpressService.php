<?php

namespace Mrdulal\LaravelVipps\Services;

use Mrdulal\LaravelVipps\Exceptions\VippsValidationException;
use Illuminate\Support\Facades\Validator;

class ExpressService
{
    protected VippsClient $client;

    public function __construct(VippsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create an express checkout session.
     */
    public function create(array $data): array
    {
        $this->validateCreateData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/ecomm/v2/payments';

        $payload = [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NOK',
            'orderId' => $data['orderId'],
            'description' => $data['description'],
            'redirectUrl' => $data['redirectUrl'],
            'userFlow' => 'WEB_REDIRECT',
            'paymentMethod' => 'WALLET',
            'skipLandingPage' => true,
            'express' => true,
        ];

        if (isset($data['userInfo'])) {
            $payload['userInfo'] = $data['userInfo'];
        }

        if (isset($data['reference'])) {
            $payload['reference'] = $data['reference'];
        }

        // Add express-specific parameters
        if (isset($data['shippingDetailsPrefix'])) {
            $payload['shippingDetailsPrefix'] = $data['shippingDetailsPrefix'];
        }

        if (isset($data['consentRemovalPrefix'])) {
            $payload['consentRemovalPrefix'] = $data['consentRemovalPrefix'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Get express session details.
     */
    public function getSession(string $orderId): array
    {
        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId;
        return $this->client->get($endpoint);
    }

    /**
     * Get shipping details for express checkout.
     */
    public function getShippingDetails(string $orderId): array
    {
        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId . '/shippingDetails';
        return $this->client->get($endpoint);
    }

    /**
     * Update express checkout with shipping details.
     */
    public function updateShippingDetails(string $orderId, array $data): array
    {
        $this->validateShippingData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/' . $orderId . '/shippingDetails';
        
        return $this->client->post($endpoint, $data);
    }

    /**
     * Generate QR code for express checkout.
     */
    public function generateQrCode(array $data): array
    {
        $this->validateQrCodeData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/qr';

        $payload = [
            'orderId' => $data['orderId'],
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NOK',
            'description' => $data['description'],
            'redirectUrl' => $data['redirectUrl'],
            'qr' => [
                'format' => $data['qrFormat'] ?? 'SVG',
                'size' => $data['qrSize'] ?? 300,
            ],
        ];

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Create shareable link for express checkout.
     */
    public function createShareableLink(array $data): array
    {
        $this->validateShareableLinkData($data);

        $endpoint = $this->client->getApiEndpoint('ecom_url') . '/payments/share';

        $payload = [
            'orderId' => $data['orderId'],
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NOK',
            'description' => $data['description'],
            'redirectUrl' => $data['redirectUrl'],
            'expiresAt' => $data['expiresAt'] ?? null,
        ];

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Validate create session data.
     */
    protected function validateCreateData(array $data): void
    {
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:100|max:99999999',
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'orderId' => 'required|string|max:50',
            'description' => 'required|string|max:100',
            'redirectUrl' => 'required|url',
            'userInfo.userId' => 'sometimes|string',
            'userInfo.mobileNumber' => 'sometimes|string',
            'userInfo.email' => 'sometimes|email',
            'reference' => 'sometimes|string|max:100',
            'shippingDetailsPrefix' => 'sometimes|string',
            'consentRemovalPrefix' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for express checkout creation',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate shipping data.
     */
    protected function validateShippingData(array $data): void
    {
        $validator = Validator::make($data, [
            'shippingDetails' => 'required|array',
            'shippingDetails.*.id' => 'required|string',
            'shippingDetails.*.priority' => 'required|integer|min:0',
            'shippingDetails.*.amount' => 'required|integer|min:0',
            'shippingDetails.*.description' => 'required|string',
            'shippingDetails.*.method' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for shipping details',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate QR code data.
     */
    protected function validateQrCodeData(array $data): void
    {
        $validator = Validator::make($data, [
            'orderId' => 'required|string|max:50',
            'amount' => 'required|integer|min:100|max:99999999',
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'description' => 'required|string|max:100',
            'redirectUrl' => 'required|url',
            'qrFormat' => 'sometimes|string|in:SVG,PNG',
            'qrSize' => 'sometimes|integer|min:100|max:2000',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for QR code generation',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate shareable link data.
     */
    protected function validateShareableLinkData(array $data): void
    {
        $validator = Validator::make($data, [
            'orderId' => 'required|string|max:50',
            'amount' => 'required|integer|min:100|max:99999999',
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'description' => 'required|string|max:100',
            'redirectUrl' => 'required|url',
            'expiresAt' => 'sometimes|date|after:now',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for shareable link creation',
                $validator->errors()->toArray()
            );
        }
    }
}