<?php

declare(strict_types=1);

namespace App\Model\Dto;

use DateTimeImmutable;
use App\Entity\Trait\IdentityTrait;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class SubscriptionDto implements IdentifiableInterface, CreatedAtInterface
{
    use IdentityTrait;
    use CreatedAtTrait;

    public function __construct(
        private ?int $id,
        #[Assert\Email]
        #[Assert\NotBlank]
        private string $email = '',
        #[Assert\IsTrue]
        #[Assert\NotBlank]
        private bool $agreed = false,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
        )]
        private ?DateTimeImmutable $createdAt = null,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): SubscriptionDto
    {
        $this->email = $email;

        return $this;
    }

    public function isAgreed(): bool
    {
        return $this->agreed;
    }

    public function setAgreed(bool $agreed): SubscriptionDto
    {
        $this->agreed = $agreed;

        return $this;
    }
}
