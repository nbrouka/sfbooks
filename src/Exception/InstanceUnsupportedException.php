<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class InstanceUnsupportedException extends RuntimeException
{
    public const MESSAGE = 'instance.unsupported';

    public function __construct(
        string $message,
    ) {
        parent::__construct($message);
    }
}
