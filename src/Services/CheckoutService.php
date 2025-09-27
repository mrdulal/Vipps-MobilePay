<?php

namespace Mrdulal\LaravelVipps\Services;

use Mrdulal\LaravelVipps\Exceptions\VippsValidationException;
use Illuminate\Support\Facades\Validator;

class CheckoutService
{
    protected VippsClient $client;

    public function __construct(VippsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new checkout session.
     */
    public function create(array $data): array
    {
        $this->validateCreateData($data);

        $endpoint = $this->client->getApiEndpoint('checkout_url') . '/session';

        $payload = [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NOK',
            'orderId' => $data['orderId'],
            'description' => $data['description'],
            'redirectUrl' => $data['redirectUrl'],
            'userFlow' => 'WEB_REDIRECT',
            'paymentMethods' => $data['paymentMethods'] ?? ['WALLET', 'CARD'],
        ];

        if (isset($data['userInfo'])) {
            $payload['userInfo'] = $data['userInfo'];
        }

        if (isset($data['logistics'])) {
            $payload['logistics'] = $data['logistics'];
        }

        if (isset($data['configuration'])) {
            $payload['configuration'] = $data['configuration'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Get checkout session details.
     */
    public function getSession(string $sessionId): array
    {
        $endpoint = $this->client->getApiEndpoint('checkout_url') . '/session/' . $sessionId;
        return $this->client->get($endpoint);
    }

    /**
     * Update checkout session.
     */
    public function updateSession(string $sessionId, array $data): array
    {
        $endpoint = $this->client->getApiEndpoint('checkout_url') . '/session/' . $sessionId;
        return $this->client->put($endpoint, $data);
    }

    /**
     * Cancel checkout session.
     */
    public function cancelSession(string $sessionId): array
    {
        $endpoint = $this->client->getApiEndpoint('checkout_url') . '/session/' . $sessionId . '/cancel';
        return $this->client->post($endpoint);
    }

    /**
     * Get payment details from checkout.
     */
    public function getPaymentDetails(string $sessionId): array
    {
        $endpoint = $this->client->getApiEndpoint('checkout_url') . '/session/' . $sessionId . '/payment';
        return $this->client->get($endpoint);
    }

    /**
     * Update logistics information.
     */
    public function updateLogistics(string $sessionId, array $data): array
    {
        $this->validateLogisticsData($data);

        $endpoint = $this->client->getApiEndpoint('checkout_url') . '/session/' . $sessionId . '/logistics';
        return $this->client->put($endpoint, $data);
    }

    /**
     * Validate checkout creation data.
     */
    protected function validateCreateData(array $data): void
    {
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:100|max:99999999',
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'orderId' => 'required|string|max:50',
            'description' => 'required|string|max:100',
            'redirectUrl' => 'required|url',
            'paymentMethods' => 'sometimes|array',
            'paymentMethods.*' => 'string|in:WALLET,CARD',
            'userInfo.userId' => 'sometimes|string',
            'userInfo.email' => 'sometimes|email',
            'userInfo.firstName' => 'sometimes|string',
            'userInfo.lastName' => 'sometimes|string',
            'userInfo.phoneNumber' => 'sometimes|string',
            'logistics.fixedOptions' => 'sometimes|array',
            'logistics.dynamicOptionsCallback' => 'sometimes|url',
            'configuration.appearance.theme' => 'sometimes|string|in:DARK,LIGHT',
            'configuration.appearance.displayName' => 'sometimes|string',
            'configuration.countries.supported' => 'sometimes|array',
            'configuration.countries.supported.*' => 'string|in:NO,DK,FI',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for checkout creation',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate logistics data.
     */
    protected function validateLogisticsData(array $data): void
    {
        $validator = Validator::make($data, [
            'fixedOptions' => 'sometimes|array',
            'fixedOptions.*.amount' => 'required|integer|min:0',
            'fixedOptions.*.description' => 'required|string',
            'fixedOptions.*.id' => 'required|string',
            'fixedOptions.*.priority' => 'sometimes|integer',
            'dynamicOptionsCallback' => 'sometimes|url',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for logistics update',
                $validator->errors()->toArray()
            );
        }
    }
}