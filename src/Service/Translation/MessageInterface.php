<?php

declare(strict_types=1);

namespace App\Service\Translation;

interface MessageInterface
{
    public function getId(): string;

    public function getDomain(): ?string;

    /** @return array<string, mixed> */
    public function getParameters(): array;
}
