<?php

namespace Mrdulal\LaravelVipps;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Container\Container;
use Mrdulal\LaravelVipps\Services\EPaymentService;
use Mrdulal\LaravelVipps\Services\CheckoutService;
use Mrdulal\LaravelVipps\Services\ExpressService;
use Mrdulal\LaravelVipps\Services\RecurringService;
use Mrdulal\LaravelVipps\Services\OrderManagementService;
use Mrdulal\LaravelVipps\Services\WebhookService;

class VippsManager
{
    protected Container $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Get the ePayment service instance.
     */
    public function ePayment(): EPaymentService
    {
        return $this->app->make(EPaymentService::class);
    }

    /**
     * Get the Checkout service instance.
     */
    public function checkout(): CheckoutService
    {
        return $this->app->make(CheckoutService::class);
    }

    /**
     * Get the Express service instance.
     */
    public function express(): ExpressService
    {
        return $this->app->make(ExpressService::class);
    }

    /**
     * Get the Recurring service instance.
     */
    public function recurring(): RecurringService
    {
        return $this->app->make(RecurringService::class);
    }

    /**
     * Get the Order Management service instance.
     */
    public function orderManagement(): OrderManagementService
    {
        return $this->app->make(OrderManagementService::class);
    }

    /**
     * Get the Webhook service instance.
     */
    public function webhook(): WebhookService
    {
        return $this->app->make(WebhookService::class);
    }
}