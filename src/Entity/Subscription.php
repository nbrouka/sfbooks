<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\IdentityTrait;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\SubscriptionRepository;
use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription implements IdentifiableInterface, CreatedAtInterface
{
    use IdentityTrait;
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
    )]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
