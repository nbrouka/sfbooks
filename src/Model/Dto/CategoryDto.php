<?php

declare(strict_types=1);

namespace App\Model\Dto;

use DateTimeImmutable;
use App\Entity\Trait\IdentityTrait;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class CategoryDto implements IdentifiableInterface, CreatedAtInterface
{
    use IdentityTrait;
    use CreatedAtTrait;

    public function __construct(
        private ?int $id,
        private ?string $title,
        private ?string $slug,
        /** @var array<int, int>|null */
        private ?array $bookIds,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
        )]
        private ?DateTimeImmutable $createdAt = null,
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /** @return array<int, int>|null */
    public function getBookIds(): ?array
    {
        return $this->bookIds;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /** @param array<int, int>|null $bookIds */
    public function setBookIds(?array $bookIds): static
    {
        $this->bookIds = $bookIds;

        return $this;
    }
}
