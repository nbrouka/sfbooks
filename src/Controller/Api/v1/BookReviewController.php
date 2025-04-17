<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Domain\BookReview\BookReviewFacade;
use App\Entity\Book;
use App\Model\Paginator;
use App\Service\OptionsResolver\PaginatorOptionsResolver;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1', name: 'book_review')]
#[OA\Tag('BookReview')]
final class BookReviewController extends ApiController
{
    public function __construct(
        private readonly BookReviewFacade $bookReviewFacade,
    ) {
    }

    #[Route('/book/{book}/reviews', methods: [Request::METHOD_GET])]
    public function getReviewsByBook(
        Book $book,
        Request $request,
        PaginatorOptionsResolver $resolver,
    ): JsonResponse {
        $queryParams = $resolver
        ->configurePage()
        ->resolve($request->query->all());

        return $this->okResponse(
            $this->bookReviewFacade->getReviewsByBook(
                $book,
                $queryParams['page'] ?? Paginator::FIRST_PAGE
            )
        );
    }
}
