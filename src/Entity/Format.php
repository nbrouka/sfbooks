<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\IdentityTrait;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\FormatRepository;
use Doctrine\Common\Collections\Collection;
use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: FormatRepository::class)]
class Format implements IdentifiableInterface, CreatedAtInterface
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
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    /**
     * @var Collection<int, BookFormat>
     */
    #[ORM\OneToMany(targetEntity: BookFormat::class, mappedBy: 'format')]
    private Collection $bookFormats;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->bookFormats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, BookFormat>
     */
    public function getBookFormats(): Collection
    {
        return $this->bookFormats;
    }

    public function addBookFormat(BookFormat $bookFormat): static
    {
        if (!$this->bookFormats->contains($bookFormat)) {
            $this->bookFormats->add($bookFormat);
            $bookFormat->setFormat($this);
        }

        return $this;
    }

    public function removeBookFormat(BookFormat $bookFormat): static
    {
        if ($this->bookFormats->removeElement($bookFormat)) {
            // set the owning side to null (unless already changed)
            if ($bookFormat->getFormat() === $this) {
                $bookFormat->setFormat(null);
            }
        }

        return $this;
    }
}
