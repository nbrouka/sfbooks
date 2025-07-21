<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTimeImmutable;

trait CreatedAtTrait
{
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
