<?php

declare(strict_types=1);

namespace App\Domain\BookRecommendation;

use App\Entity\Book;

class BookRecommendationFacade
{
    public function __construct(
        private BookRecommendationManager $manager,
    ) {
    }

    public function getRecommendationsByBook(Book $book): array
    {
        return $this->manager->getRecommendationsByBook($book);
    }
}
