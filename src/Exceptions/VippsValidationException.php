<?php

namespace Mrdulal\LaravelVipps\Exceptions;

class VippsValidationException extends VippsException
{
    protected array $validationErrors;

    public function __construct(string $message = '', array $validationErrors = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->validationErrors = $validationErrors;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}