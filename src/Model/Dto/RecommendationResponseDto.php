<?php

declare(strict_types=1);

namespace App\Model\Dto;

class RecommendationResponseDto
{
    public function __construct(
        private readonly array $data = [],
    ) {
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
