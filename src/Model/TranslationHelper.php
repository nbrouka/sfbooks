<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\SubscriptionAlreadyExistsException;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslationHelper
{
    public const EXCEPTION_DOMAIN = 'exception';

    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function getSubscriptionAlreadyExistsMessage()
    {
        return $this->translator->trans(
            id: SubscriptionAlreadyExistsException::SUBSCRIPTION_ALREADY_EXISTS,
            domain: self::EXCEPTION_DOMAIN
        );
    }
}
