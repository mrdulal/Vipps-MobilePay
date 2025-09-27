<?php

namespace Mrdulal\LaravelVipps\Tests\Unit;

use Mrdulal\LaravelVipps\Tests\TestCase;
use Mrdulal\LaravelVipps\Services\VippsClient;
use Mrdulal\LaravelVipps\Exceptions\VippsException;
use Mrdulal\LaravelVipps\Exceptions\VippsApiException;

class VippsClientTest extends TestCase
{
    public function test_client_can_be_instantiated(): void
    {
        $config = [
            'environment' => 'test',
            'client_id' => 'test_client_id',
            'client_secret' => 'test_client_secret',
            'subscription_key' => 'test_subscription_key',
            'merchant_serial_number' => '123456',
            'api_endpoints' => [
                'test' => [
                    'base_url' => 'https://apitest.vipps.no',
                    'ecom_url' => 'https://apitest.vipps.no/ecomm/v2',
                ],
            ],
            'http' => [
                'timeout' => 30,
                'connect_timeout' => 10,
                'verify' => true,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ],
            'logging' => [
                'enabled' => false,
            ],
            'cache' => [
                'enabled' => false,
            ],
        ];

        $client = new VippsClient($config);

        $this->assertInstanceOf(VippsClient::class, $client);
        $this->assertEquals('test', $client->getEnvironment());
        $this->assertTrue($client->isTestMode());
    }

    public function test_get_api_endpoint_returns_correct_url(): void
    {
        $config = [
            'environment' => 'test',
            'api_endpoints' => [
                'test' => [
                    'base_url' => 'https://apitest.vipps.no',
                    'ecom_url' => 'https://apitest.vipps.no/ecomm/v2',
                ],
            ],
            'http' => ['timeout' => 30],
            'logging' => ['enabled' => false],
            'cache' => ['enabled' => false],
        ];

        $client = new VippsClient($config);

        $this->assertEquals('https://apitest.vipps.no', $client->getApiEndpoint('base_url'));
        $this->assertEquals('https://apitest.vipps.no/ecomm/v2', $client->getApiEndpoint('ecom_url'));
    }
}