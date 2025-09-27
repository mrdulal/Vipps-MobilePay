<?php

namespace Mrdulal\LaravelVipps\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecurringChargeCreated
{
    use Dispatchable, SerializesModels;

    public string $orderId;
    public array $payload;

    public function __construct(string $orderId, array $payload)
    {
        $this->orderId = $orderId;
        $this->payload = $payload;
    }
}