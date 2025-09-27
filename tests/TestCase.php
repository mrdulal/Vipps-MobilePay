<?php

namespace SushriDad\LaravelVipps\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use SushriDad\LaravelVipps\VippsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Additional setup if needed
    }

    protected function getPackageProviders($app): array
    {
        return [
            VippsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Vipps' => 'SushriDad\LaravelVipps\Facades\Vipps',
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('vipps.environment', 'test');
        $app['config']->set('vipps.client_id', 'test_client_id');
        $app['config']->set('vipps.client_secret', 'test_client_secret');
        $app['config']->set('vipps.subscription_key', 'test_subscription_key');
        $app['config']->set('vipps.merchant_serial_number', '123456');
    }
}