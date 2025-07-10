<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class UserNotFoundException extends RuntimeException
{
    public const MESSAGE = 'user.not_found';

    public function __construct(
        string $message,
    ) {
        parent::__construct($message);
    }
}
