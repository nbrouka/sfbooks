<?php

declare(strict_types=1);

namespace App\Model\Dto;

class RecommendationResponseDto
{
    /** @param array<string, mixed> $data */
    public function __construct(
        private array $data = [],
    ) {
    }

    /** @return array<string, mixed> */
    public function getData(): array
    {
        return $this->data;
    }

    /** @param array<string, mixed> $data */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
