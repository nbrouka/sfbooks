<?php

declare(strict_types=1);

namespace App\Domain\Review;

use App\Entity\Review;
use App\Model\Dto\ReviewDto;

class ReviewMapper
{
    public function createReviewDto(Review $review): ReviewDto
    {
        return new ReviewDto(
            $review->getId(),
            $review->getRating(),
            $review->getContent(),
            $review->getCreatedAt()
        );
    }

    /**
     * @param array<Review> $reviews
     *
     * @return array<ReviewDto>
     **/
    public function createReviewDtoList(array $reviews): array
    {
        return array_map([$this, 'createReviewDto'], $reviews);
    }
}
