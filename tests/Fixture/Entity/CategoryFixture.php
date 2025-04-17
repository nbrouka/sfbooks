<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Entity;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\Dto\CategoryDto;
use App\Tests\Factory\BookFactory;
use Doctrine\Common\Collections\ArrayCollection;

class CategoryFixture
{
    public static function createFromDto(CategoryDto $categoryDto): Category
    {
        $bookIds = $categoryDto->getBookIds();

        /** @var Book[] $books */
        $books = BookFactory::new()->createMany(
            count($bookIds),
            static function (int $i) use ($bookIds): array {
                return ['id' => $bookIds[$i - 1]];
            }
        );

        return (new Category())
            ->setId($categoryDto->getId())
            ->setTitle($categoryDto->getTitle())
            ->setSlug($categoryDto->getSlug())
            ->setBooks(new ArrayCollection($books))
            ->setCreatedAt($categoryDto->getCreatedAt());
    }
}
