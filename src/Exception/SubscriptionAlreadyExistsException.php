<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class SubscriptionAlreadyExistsException extends RuntimeException
{
    public const MESSAGE = 'subscription.already_exists';

    public function __construct(
        string $message,
    ) {
        parent::__construct($message);
    }
}
