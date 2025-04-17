<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;

class ValidationException extends \RuntimeException
{
    /** @param ConstraintViolationInterface[] $violations */
    public function __construct(
        private readonly array $violations,
    ) {
        parent::__construct('validation_failed');
    }

    /** @return ConstraintViolationInterface[] */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
