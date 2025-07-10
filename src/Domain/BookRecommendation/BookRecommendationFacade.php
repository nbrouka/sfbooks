<?php

declare(strict_types=1);

namespace App\Domain\BookRecommendation;

use App\Entity\Book;
use App\Model\Dto\BookDto;

class BookRecommendationFacade
{
    public function __construct(
        private BookRecommendationManager $manager,
    ) {
    }

    /**
     * @return array<BookDto>
     */
    public function getRecommendationsByBook(Book $book): array
    {
        return $this->manager->getRecommendationsByBook($book);
    }
}
