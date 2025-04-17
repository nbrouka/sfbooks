<?php

declare(strict_types=1);

namespace App\Model\Error;

class ErrorValidationDetails
{
    /**
     * @param ErrorValidationDetailsItem[] $violations
     */
    public function __construct(
        private array $violations = [],
    ) {
    }

    public function addViolation(string $field, string $message): void
    {
        $this->violations[] = new ErrorValidationDetailsItem($field, $message);
    }

    /** @return ErrorValidationDetailsItem[] */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
