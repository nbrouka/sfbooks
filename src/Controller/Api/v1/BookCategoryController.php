<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Domain\BookCategory\BookCategoryFacade;
use App\Entity\Category;
use App\Model\Paginator;
use App\Service\OptionsResolver\PaginatorOptionsResolver;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1', name: 'book_category')]
#[OA\Tag('BookCategory')]
final class BookCategoryController extends ApiController
{
    public function __construct(
        private readonly BookCategoryFacade $bookCategoryFacade,
    ) {
    }

    #[Route('/category/{category}/books', methods: [Request::METHOD_GET])]
    public function getBooksByCategory(
        Category $category,
        Request $request,
        PaginatorOptionsResolver $resolver,
    ): JsonResponse {
        $queryParams = $resolver
        ->configurePage()
        ->resolve($request->query->all());

        return $this->okResponse(
            $this->bookCategoryFacade->getBooksByCategory(
                $category,
                $queryParams['page'] ?? Paginator::FIRST_PAGE
            )
        );
    }
}
