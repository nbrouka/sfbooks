<?php

declare(strict_types=1);

namespace App\Domain\BookReview;

use App\Entity\Book;
use App\Model\Dto\ReviewsPageDto;

class BookReviewFacade
{
    public function __construct(
        private BookReviewManager $manager,
    ) {
    }

    public function getReviewsByBook(Book $book, int $page): ReviewsPageDto
    {
        return $this->manager->getReviewsByBook($book, $page);
    }
}
