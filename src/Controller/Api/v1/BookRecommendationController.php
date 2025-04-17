<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Domain\BookRecommendation\BookRecommendationFacade;
use App\Entity\Book;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1', name: 'recommendation')]
#[OA\Tag('Recommendation')]
final class BookRecommendationController extends ApiController
{
    public function __construct(
        private readonly BookRecommendationFacade $bookRecommendationFacade,
    ) {
    }

    #[Route('/book/{book}/recommendations', methods: [Request::METHOD_GET])]
    public function getRecommendationsByBook(
        Book $book
    ): JsonResponse {
        return $this->okResponse(
            $this->bookRecommendationFacade->getRecommendationsByBook($book)
        );
    }
}
