<?php

declare(strict_types=1);

namespace App\Model\Dto;

use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\IdentityTrait;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

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
        private ?\DateTimeImmutable $createdAt = null,
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
