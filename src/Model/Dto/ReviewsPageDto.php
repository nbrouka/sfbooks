<?php

declare(strict_types=1);

namespace App\Model\Dto;

use App\Entity\Review;
use App\Model\Paginator;

class ReviewsPageDto
{
    /** @param Paginator<Review> $paginator */
    public function __construct(
        public Paginator $paginator,
        public float $rating = 0,
    ) {
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /** @return Paginator<Review> */
    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    /** @param Paginator<Review> $paginator */
    public function setPaginator(Paginator $paginator): static
    {
        $this->paginator = $paginator;

        return $this;
    }
}
