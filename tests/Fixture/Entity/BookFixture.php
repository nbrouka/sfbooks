<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Entity;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\Dto\BookDto;
use App\Model\Enum\BookLevel;
use App\Model\Enum\BookType;
use App\Model\Enum\ProgramLanguage;
use App\Tests\Factory\CategoryFactory;
use Doctrine\Common\Collections\ArrayCollection;

class BookFixture
{
    public static function createFromDto(BookDto $bookDto): Book
    {
        $categoryIds = $bookDto->getCategoryIds();

        /** @var Category[] $categories */
        $categories = CategoryFactory::new()->createMany(
            count($categoryIds),
            static function (int $i) use ($categoryIds): array {
                return ['id' => $categoryIds[$i - 1]];
            }
        );

        return (new Book())
            ->setId($bookDto->getId())
            ->setType(BookType::from($bookDto->getType()))
            ->setLevel(BookLevel::from($bookDto->getLevel()))
            ->setLanguage(ProgramLanguage::from($bookDto->getLanguage()))
            ->setCategories(new ArrayCollection($categories))
            ->setPublished($bookDto->getPublished())
            ->setIsbn($bookDto->getIsbn())
            ->setTitle($bookDto->getTitle())
            ->setDescription($bookDto->getDescription())
            ->setCoverFileName($bookDto->getCoverFileName())
            ->setMeap($bookDto->getMeap())
            ->setCreatedAt($bookDto->getCreatedAt());
    }
}
