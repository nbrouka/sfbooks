<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\IdentityTrait;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\BookUserRepository;
use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: BookUserRepository::class)]
class BookUser implements IdentifiableInterface, CreatedAtInterface
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

    #[ORM\ManyToOne(inversedBy: 'bookUsers')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'bookUsers')]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
