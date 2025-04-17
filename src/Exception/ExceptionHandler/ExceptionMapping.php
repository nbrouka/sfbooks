<?php

declare(strict_types=1);

namespace App\Exception\ExceptionHandler;

final class ExceptionMapping
{
    public function __construct(
        readonly private int $code,
        readonly private bool $hidden,
        readonly private bool $loggable,
    ) {
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public static function fromCode(int $code): static
    {
        return new static($code, true, false);
    }
}
