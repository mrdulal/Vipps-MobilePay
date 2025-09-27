<?php

namespace Mrdulal\LaravelVipps\Exceptions;

class VippsApiException extends VippsException
{
    protected array $apiError;

    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null, array $apiError = [])
    {
        parent::__construct($message, $code, $previous);
        $this->apiError = $apiError;
    }

    public function getApiError(): array
    {
        return $this->apiError;
    }
}