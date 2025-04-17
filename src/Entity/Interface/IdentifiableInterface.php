<?php

declare(strict_types=1);

namespace App\Entity\Interface;

interface IdentifiableInterface
{
    public function getId(): ?int;

    public function setId(?int $id): static;
}
