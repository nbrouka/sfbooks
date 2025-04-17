<?php

declare(strict_types=1);

namespace App\Model\Dto;

use App\Model\Paginator;

class ReviewsPageDto
{
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

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    public function setPaginator(Paginator $paginator): static
    {
        $this->paginator = $paginator;

        return $this;
    }
}
