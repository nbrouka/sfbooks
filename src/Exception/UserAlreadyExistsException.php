<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class UserAlreadyExistsException extends RuntimeException
{
    public const MESSAGE = 'user.already_exists';

    public function __construct(
        string $message,
    ) {
        parent::__construct($message);
    }
}
