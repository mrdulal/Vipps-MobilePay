<?php

namespace Mrdulal\LaravelVipps\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Mrdulal\LaravelVipps\Services\EPaymentService ePayment()
 * @method static \Mrdulal\LaravelVipps\Services\CheckoutService checkout()
 * @method static \Mrdulal\LaravelVipps\Services\ExpressService express()
 * @method static \Mrdulal\LaravelVipps\Services\RecurringService recurring()
 * @method static \Mrdulal\LaravelVipps\Services\OrderManagementService orderManagement()
 * @method static \Mrdulal\LaravelVipps\Services\WebhookService webhook()
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