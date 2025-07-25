<?php

namespace App\Entity;

use App\Repository\BookUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookUserRepository::class)]
class BookUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookUsers')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'bookUsers')]
    private ?User $user1 = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser1(): ?User
    {
        return $this->user1;
    }

    public function setUser1(?User $user1): static
    {
        $this->user1 = $user1;

        return $this;
    }
}
