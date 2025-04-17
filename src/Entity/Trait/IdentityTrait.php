<?php

declare(strict_types=1);

namespace App\Entity\Trait;

trait IdentityTrait
{
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }
}
