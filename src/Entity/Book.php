<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use App\Model\Enum\BookType;
use App\Model\Enum\BookLevel;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use App\Entity\Trait\IdentityTrait;
use App\Model\Enum\ProgramLanguage;
use App\Entity\Trait\CreatedAtTrait;
use Doctrine\Common\Collections\Collection;
use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book implements IdentifiableInterface, CreatedAtInterface
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverFileName = null;

    #[ORM\Column(length: 13, nullable: true)]
    #[Assert\Isbn(
        type: Assert\Isbn::ISBN_13,
        message: 'book.isbn13.not_valid',
    )]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    private Collection $categories;

    #[ORM\Column(nullable: false)]
    private bool $meap = false;

    #[ORM\Column(nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
    )]
    private ?DateTimeImmutable $published = null;

    #[ORM\Column(nullable: true, enumType: BookType::class)]
    #[Assert\Choice(
        callback: [BookType::class, 'getValues'],
        message: 'book.type.not_valid',
    )]
    private ?BookType $type = null;

    #[ORM\Column(nullable: true, enumType: BookLevel::class)]
    #[Assert\Choice(
        callback: [BookLevel::class, 'getValues'],
        message: 'book.level.not_valid',
    )]
    private ?BookLevel $level = null;

    #[ORM\Column(nullable: true, enumType: ProgramLanguage::class)]
    #[Assert\Choice(
        callback: [ProgramLanguage::class, 'getValues'],
        message: 'book.language.not_valid',
    )]
    private ?ProgramLanguage $language = null;

    /**
     * @var Collection<int, BookFormat>
     */
    #[ORM\OneToMany(targetEntity: BookFormat::class, mappedBy: 'book')]
    private Collection $bookFormats;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'book')]
    private Collection $reviews;

    /**
     * @var Collection<int, BookUser>
     */
    #[ORM\OneToMany(targetEntity: BookUser::class, mappedBy: 'book')]
    private Collection $bookUsers;

    public function __construct()
    {
        $this->type = BookType::DEFAULT;
        $this->categories = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->bookFormats = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->bookUsers = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCoverFileName(): ?string
    {
        return $this->coverFileName;
    }

    public function setCoverFileName(?string $coverFileName): static
    {
        $this->coverFileName = $coverFileName;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): static
    {
        $this->isbn = $isbn;

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

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection<int, Category> $categories
     */
    public function setCategories(Collection $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return array<int>
     */
    public function getCategoryIds(): ?array
    {
        return $this->categories->map(
            fn (Category $category) => $category->getId()
        )->toArray();
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addBook($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function isMeap(): bool
    {
        return $this->meap;
    }

    public function setMeap(bool $meap): static
    {
        $this->meap = $meap;

        return $this;
    }

    public function getMeap(): bool
    {
        return $this->meap;
    }

    public function getPublished(): ?DateTimeImmutable
    {
        return $this->published;
    }

    public function setPublished(?DateTimeImmutable $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getType(): ?BookType
    {
        return $this->type;
    }

    public function setType(?BookType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLevel(): ?BookLevel
    {
        return $this->level;
    }

    public function setLevel(?BookLevel $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getLanguage(): ?ProgramLanguage
    {
        return $this->language;
    }

    public function setLanguage(?ProgramLanguage $language): static
    {
        $this->language = $language;

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
            $bookFormat->setBook($this);
        }

        return $this;
    }

    public function removeBookFormat(BookFormat $bookFormat): static
    {
        if ($this->bookFormats->removeElement($bookFormat)) {
            // set the owning side to null (unless already changed)
            if ($bookFormat->getBook() === $this) {
                $bookFormat->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setBook($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getBook() === $this) {
                $review->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookUser>
     */
    public function getBookUsers(): Collection
    {
        return $this->bookUsers;
    }

    public function addBookUser(BookUser $bookUser): static
    {
        if (!$this->bookUsers->contains($bookUser)) {
            $this->bookUsers->add($bookUser);
            $bookUser->setBook($this);
        }

        return $this;
    }

    public function removeBookUser(BookUser $bookUser): static
    {
        if ($this->bookUsers->removeElement($bookUser)) {
            // set the owning side to null (unless already changed)
            if ($bookUser->getBook() === $this) {
                $bookUser->setBook(null);
            }
        }

        return $this;
    }
}
