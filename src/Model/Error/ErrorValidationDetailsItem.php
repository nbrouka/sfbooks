<?php

declare(strict_types=1);

namespace App\Model\Error;

class ErrorValidationDetailsItem
{
    public function __construct(
        private readonly string $field,
        private readonly string $message,
    ) {
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
