<?php

declare (strict_types=1);

namespace App\Domain\BookRecommendation;

use App\Entity\Book;
use App\Domain\Book\BookMapper;
use App\Repository\BookRepository;
use App\Service\Recommendation\RecommendationService;

class BookRecommendationManager
{
    public function __construct(
        private readonly RecommendationService $recommendationService,
        private readonly BookRepository $bookRepository,
        private readonly BookMapper $bookMapper
    ) {
    }

    /**
     * @return array<BookDto>
     */
    public function getRecommendationsByBook(Book $book): array
    {
        $ids = $this->recommendationService->getRecommendationsByBook($book)->getData();

        return $this->bookMapper->createBookDtoList($this->bookRepository->findByIds($ids)->toArray());
    }
}
