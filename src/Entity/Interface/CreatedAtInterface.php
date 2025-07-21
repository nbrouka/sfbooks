<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use DateTimeImmutable;

interface CreatedAtInterface
{
    public function getCreatedAt(): ?DateTimeImmutable;

    public function setCreatedAt(?DateTimeImmutable $createdAt): static;
}
