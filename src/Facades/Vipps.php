<?php

namespace SushriDad\LaravelVipps\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \SushriDad\LaravelVipps\Services\EPaymentService ePayment()
 * @method static \SushriDad\LaravelVipps\Services\CheckoutService checkout()
 * @method static \SushriDad\LaravelVipps\Services\ExpressService express()
 * @method static \SushriDad\LaravelVipps\Services\RecurringService recurring()
 * @method static \SushriDad\LaravelVipps\Services\OrderManagementService orderManagement()
 * @method static \SushriDad\LaravelVipps\Services\WebhookService webhook()
 */
class Vipps extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'vipps';
    }
}