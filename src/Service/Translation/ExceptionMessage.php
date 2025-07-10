<?php

declare(strict_types=1);

namespace App\Service\Translation;

class ExceptionMessage extends Message
{
    public const EXCEPTION_DOMAIN = 'exception';

    public function getDomain(): ?string
    {
        return self::EXCEPTION_DOMAIN;
    }
}
