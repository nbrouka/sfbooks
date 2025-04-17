<?php

declare(strict_types=1);

namespace App\Model\Dto;

use App\Entity\Interface\CreatedAtInterface;
use App\Entity\Interface\IdentifiableInterface;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\IdentityTrait;
use App\Model\Enum\BookLevel;
use App\Model\Enum\BookType;
use App\Model\Enum\ProgramLanguage;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

class BookDto implements IdentifiableInterface, CreatedAtInterface
{
    use IdentityTrait;
    use CreatedAtTrait;

    public function __construct(
        private ?int $id,
        private ?string $title,
        private ?string $description,
        #[Assert\Choice(
            callback: [BookLevel::class, 'getValues'],
            message: 'book.level.not_valid'
        )]
        private ?string $level,
        #[Assert\Choice(
            callback: [BookType::class, 'getValues'],
            message: 'book.type.not_valid'
        )]
        private ?string $type,
        #[Assert\Choice(
            callback: [ProgramLanguage::class, 'getValues'],
            message: 'book.language.not_valid'
        )]
        private ?string $language,
        #[Assert\Isbn(
            type: Assert\Isbn::ISBN_13,
            message: 'book.isbn13.not_valid',
        )]
        private ?string $isbn,
        private ?string $coverFileName,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
        )]
        private ?\DateTimeImmutable $published,
        private ?bool $meap,
        /** @var array<int, int>|null */
        private ?array $categoryIds,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s']
        )]
        private ?\DateTimeImmutable $createdAt = null,
    ) {
    }

    /**
     * @param array<int, int> $categoryIds
     */
    public function setCategoryIds(array $categoryIds): static
    {
        $this->categoryIds = $categoryIds;

        return $this;
    }

    /**
     * @return array<int, int>|null
     */
    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

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

    public function getCoverFileName(): ?string
    {
        return $this->coverFileName;
    }

    public function setCoverFileName(?string $coverFileName): static
    {
        $this->coverFileName = $coverFileName;

        return $this;
    }

    public function getPublished(): ?\DateTimeImmutable
    {
        return $this->published;
    }

    public function setPublished(?\DateTimeImmutable $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getMeap(): ?bool
    {
        return $this->meap;
    }

    public function setMeap(?bool $meap): static
    {
        $this->meap = $meap;

        return $this;
    }
}
