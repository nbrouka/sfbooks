<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;
use RuntimeException;

class AccessDeniedException extends RuntimeException
{
    public function __construct(
        string $message,
        Throwable $previous,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
