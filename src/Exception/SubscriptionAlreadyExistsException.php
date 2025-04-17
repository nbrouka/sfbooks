<?php

declare(strict_types=1);

namespace App\Exception;

class SubscriptionAlreadyExistsException extends \RuntimeException
{
    public const SUBSCRIPTION_ALREADY_EXISTS = 'subscription.already_exists';

    public function __construct(
        string $message,
    ) {
        parent::__construct($message);
    }
}
