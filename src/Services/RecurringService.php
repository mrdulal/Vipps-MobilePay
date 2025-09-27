<?php

namespace Mrdulal\LaravelVipps\Services;

use Mrdulal\LaravelVipps\Exceptions\VippsValidationException;
use Illuminate\Support\Facades\Validator;

class RecurringService
{
    protected VippsClient $client;

    public function __construct(VippsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new recurring agreement.
     */
    public function createAgreement(array $data): array
    {
        $this->validateAgreementData($data);

        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements';

        $payload = [
            'currency' => $data['currency'] ?? 'NOK',
            'price' => $data['price'],
            'productName' => $data['productName'],
            'productDescription' => $data['productDescription'],
            'merchantRedirectUrl' => $data['merchantRedirectUrl'],
            'merchantAgreementUrl' => $data['merchantAgreementUrl'],
            'interval' => $data['interval'] ?? 'MONTH',
            'intervalCount' => $data['intervalCount'] ?? 1,
            'isApp' => $data['isApp'] ?? false,
        ];

        if (isset($data['phoneNumber'])) {
            $payload['phoneNumber'] = $data['phoneNumber'];
        }

        if (isset($data['userInfo'])) {
            $payload['userInfo'] = $data['userInfo'];
        }

        if (isset($data['campaign'])) {
            $payload['campaign'] = $data['campaign'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Get agreement details.
     */
    public function getAgreement(string $agreementId): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId;
        return $this->client->get($endpoint);
    }

    /**
     * Update agreement.
     */
    public function updateAgreement(string $agreementId, array $data): array
    {
        $this->validateUpdateAgreementData($data);

        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId;
        
        return $this->client->put($endpoint, $data);
    }

    /**
     * Stop agreement.
     */
    public function stopAgreement(string $agreementId, array $data = []): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/stop';
        
        $payload = [
            'status' => 'STOPPED',
            'reason' => $data['reason'] ?? 'Cancelled by merchant',
        ];

        return $this->client->patch($endpoint, $payload);
    }

    /**
     * Create a charge for an agreement.
     */
    public function createCharge(string $agreementId, array $data): array
    {
        $this->validateChargeData($data);

        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/charges';

        $payload = [
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'NOK',
            'description' => $data['description'],
            'orderId' => $data['orderId'],
        ];

        if (isset($data['dueDate'])) {
            $payload['dueDate'] = $data['dueDate'];
        }

        if (isset($data['retryDays'])) {
            $payload['retryDays'] = $data['retryDays'];
        }

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Get charge details.
     */
    public function getCharge(string $agreementId, string $chargeId): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/charges/' . $chargeId;
        return $this->client->get($endpoint);
    }

    /**
     * Cancel a charge.
     */
    public function cancelCharge(string $agreementId, string $chargeId): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/charges/' . $chargeId . '/cancel';
        return $this->client->post($endpoint);
    }

    /**
     * Capture a charge.
     */
    public function captureCharge(string $agreementId, string $chargeId, array $data = []): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/charges/' . $chargeId . '/capture';
        
        $payload = [
            'amount' => $data['amount'] ?? null,
            'description' => $data['description'] ?? 'Charge captured',
        ];

        return $this->client->post($endpoint, $payload);
    }

    /**
     * Refund a charge.
     */
    public function refundCharge(string $agreementId, string $chargeId, array $data): array
    {
        $this->validateRefundData($data);

        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/charges/' . $chargeId . '/refund';
        
        $payload = [
            'amount' => $data['amount'],
            'description' => $data['description'],
        ];

        return $this->client->post($endpoint, $payload);
    }

    /**
     * List charges for an agreement.
     */
    public function listCharges(string $agreementId): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements/' . $agreementId . '/charges';
        return $this->client->get($endpoint);
    }

    /**
     * List agreements.
     */
    public function listAgreements(array $filters = []): array
    {
        $endpoint = $this->client->getApiEndpoint('recurring_url') . '/agreements';
        
        if (!empty($filters)) {
            $queryString = http_build_query($filters);
            $endpoint .= '?' . $queryString;
        }

        return $this->client->get($endpoint);
    }

    /**
     * Validate agreement creation data.
     */
    protected function validateAgreementData(array $data): void
    {
        $validator = Validator::make($data, [
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'price' => 'required|integer|min:100|max:99999999',
            'productName' => 'required|string|max:45',
            'productDescription' => 'required|string|max:100',
            'merchantRedirectUrl' => 'required|url',
            'merchantAgreementUrl' => 'required|url',
            'interval' => 'sometimes|string|in:WEEK,MONTH,YEAR',
            'intervalCount' => 'sometimes|integer|min:1|max:31',
            'isApp' => 'sometimes|boolean',
            'phoneNumber' => 'sometimes|string',
            'userInfo.userId' => 'sometimes|string',
            'campaign.start' => 'sometimes|date',
            'campaign.end' => 'sometimes|date|after:campaign.start',
            'campaign.price' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for recurring agreement creation',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate agreement update data.
     */
    protected function validateUpdateAgreementData(array $data): void
    {
        $validator = Validator::make($data, [
            'productName' => 'sometimes|string|max:45',
            'productDescription' => 'sometimes|string|max:100',
            'price' => 'sometimes|integer|min:100|max:99999999',
            'status' => 'sometimes|string|in:ACTIVE,STOPPED,EXPIRED',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for recurring agreement update',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate charge creation data.
     */
    protected function validateChargeData(array $data): void
    {
        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:100|max:99999999',
            'currency' => 'sometimes|string|in:NOK,DKK,EUR',
            'description' => 'required|string|max:45',
            'orderId' => 'required|string|max:50',
            'dueDate' => 'sometimes|date|after:now',
            'retryDays' => 'sometimes|integer|min:0|max:14',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for charge creation',
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
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for charge refund',
                $validator->errors()->toArray()
            );
        }
    }
}