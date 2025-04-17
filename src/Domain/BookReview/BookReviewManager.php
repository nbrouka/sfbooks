<?php

declare(strict_types=1);

namespace App\Domain\BookReview;

use App\Domain\Review\ReviewMapper;
use App\Entity\Book;
use App\Entity\Review;
use App\Model\Dto\ReviewsPageDto;
use App\Model\Paginator;
use App\Repository\ReviewRepository;

/**
 * @return Paginator<Review>
 */
class BookReviewManager
{
    public function __construct(
        private ReviewRepository $reviewRepository,
        private ReviewMapper $reviewMapper,
    ) {
    }

    public function getReviewsByBook(Book $book, int $page): ReviewsPageDto
    {
        $result = $this->reviewRepository->findByBook($book, $page);
        $rating = $result->getTotal() > 0
            ? $this->reviewRepository->getRatingSumByBook($book) / $result->getTotal()
            : 0;

        $reviewDtoList = $this->reviewMapper->createReviewDtoList(
            $result->getData()
        );

        return new ReviewsPageDto(
            $result->setData($reviewDtoList),
            $rating
        );
    }
}
