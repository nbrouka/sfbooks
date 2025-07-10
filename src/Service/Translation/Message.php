<?php

declare(strict_types=1);

namespace App\Service\Translation;

abstract class Message implements MessageInterface
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function __construct(
        public readonly string $id,
        public readonly array $parameters = [],
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    /** @return array<string, mixed> */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    abstract public function getDomain(): ?string;
}
