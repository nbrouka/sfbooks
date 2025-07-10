<?php

declare(strict_types=1);

namespace App\Service\Translation;

use Symfony\Contracts\Translation\TranslatorInterface;

class TranslationHelper
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function getTranslation(MessageInterface $message): string
    {
        return $this->translator->trans(
            id: $message->getId(),
            parameters: $$message->getParameters(),
            domain: $message->getDomain(),
        );
    }
}
