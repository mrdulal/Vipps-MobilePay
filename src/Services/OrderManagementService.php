<?php

namespace Mrdulal\LaravelVipps\Services;

use Mrdulal\LaravelVipps\Exceptions\VippsValidationException;
use Illuminate\Support\Facades\Validator;

class OrderManagementService
{
    protected VippsClient $client;

    public function __construct(VippsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Capture a payment.
     */
    public function capture(string $orderId, array $data): array
    {
        $this->validateCaptureData($data);

        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/capture';
        
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

        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/refund';
        
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
     * Cancel a payment.
     */
    public function cancel(string $orderId, array $data = []): array
    {
        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/cancel';
        
        $payload = [
            'description' => $data['description'] ?? 'Order cancelled',
        ];

        return $this->client->put($endpoint, $payload);
    }

    /**
     * Get payment history.
     */
    public function getPaymentHistory(string $orderId): array
    {
        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/history';
        return $this->client->get($endpoint);
    }

    /**
     * Get order status.
     */
    public function getOrderStatus(string $orderId): array
    {
        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/status';
        return $this->client->get($endpoint);
    }

    /**
     * Add order receipt category.
     */
    public function addReceiptCategory(string $orderId, array $data): array
    {
        $this->validateReceiptCategoryData($data);

        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/receipt';
        
        return $this->client->post($endpoint, $data);
    }

    /**
     * Send receipt to customer.
     */
    public function sendReceipt(string $orderId, array $data): array
    {
        $this->validateReceiptData($data);

        $endpoint = $this->client->getApiEndpoint('order_management_url') . '/orders/' . $orderId . '/receipt/send';
        
        return $this->client->post($endpoint, $data);
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

    /**
     * Validate receipt category data.
     */
    protected function validateReceiptCategoryData(array $data): void
    {
        $validator = Validator::make($data, [
            'category' => 'required|string|in:RECEIPT,TICKET,DELIVERY,BOOKING,GENERAL',
            'link' => 'required|url',
            'image' => 'sometimes|string',
            'imageSize' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for receipt category',
                $validator->errors()->toArray()
            );
        }
    }

    /**
     * Validate receipt data.
     */
    protected function validateReceiptData(array $data): void
    {
        $validator = Validator::make($data, [
            'orderLines' => 'required|array',
            'orderLines.*.name' => 'required|string',
            'orderLines.*.id' => 'required|string',
            'orderLines.*.totalAmount' => 'required|integer',
            'orderLines.*.totalAmountExcludingTax' => 'sometimes|integer',
            'orderLines.*.totalTaxAmount' => 'sometimes|integer',
            'orderLines.*.taxRate' => 'sometimes|numeric',
            'orderLines.*.unitInfo.unitPrice' => 'sometimes|integer',
            'orderLines.*.unitInfo.quantity' => 'sometimes|string',
            'orderLines.*.unitInfo.quantityUnit' => 'sometimes|string',
            'bottomLine.currency' => 'required|string|in:NOK,DKK,EUR',
            'bottomLine.tipAmount' => 'sometimes|integer',
            'bottomLine.barcode.format' => 'sometimes|string',
            'bottomLine.barcode.data' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            throw new VippsValidationException(
                'Validation failed for receipt data',
                $validator->errors()->toArray()
            );
        }
    }
}