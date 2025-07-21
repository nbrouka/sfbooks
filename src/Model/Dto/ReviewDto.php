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

class ReviewDto implements IdentifiableInterface, CreatedAtInterface
{
    use IdentityTrait;
    use CreatedAtTrait;

    public function __construct(
        private ?int $id,
        private ?int $rating,
        private ?string $content,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
        )]
        private ?DateTimeImmutable $createdAt = null,
    ) {
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
