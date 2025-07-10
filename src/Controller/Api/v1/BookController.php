<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Domain\Book\BookFacade;
use App\Domain\Book\BookMapper;
use App\Entity\Book;
use App\Model\Dto\BookDto;
use App\Model\OpenApi\OAParameterPath;
use App\Model\OpenApi\OAParameterQuery;
use App\Model\OpenApi\OARequest;
use App\Model\OpenApi\OAResponse;
use App\Model\OpenApi\OAResponseCreated;
use App\Model\OpenApi\OAResponseDeleted;
use App\Model\OpenApi\OAResponseValidation;
use App\Model\Paginator;
use App\Service\OptionsResolver\PaginatorOptionsResolver;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/book', name: 'book_')]
#[OA\Tag('Book')]
final class BookController extends ApiController
{
    public function __construct(
        private BookFacade $bookFacade,
        private BookMapper $bookMapper,
    ) {
    }

    #[Route('/{book}', name: 'get_one', requirements: ['book' => '\d+'], methods: [Request::METHOD_GET])]
    #[OAParameterPath('book'), OAResponse(BookDto::class)]
    public function getOne(Book $book): JsonResponse
    {
        return $this->okResponse($this->bookMapper->createBookDto($book));
    }

    #[Route('', name: 'get_list', methods: [Request::METHOD_GET])]
    #[OAParameterQuery('page', 'Pagination parameter'), OAResponse([BookDto::class])]
    public function getList(Request $request, PaginatorOptionsResolver $resolver): JsonResponse
    {
        try {
            $queryParams = $resolver
                ->configurePage()
                ->resolve($request->query->all());

            return $this->okResponse($this->bookFacade->list($queryParams['page'] ?? Paginator::FIRST_PAGE));
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    #[Route('', name: 'create', methods: [Request::METHOD_POST])]
    #[OARequest(BookDto::class), OAResponseCreated(BookDto::class), OAResponseValidation]
    public function create(#[MapRequestPayload] BookDto $book): JsonResponse
    {
        return $this->createdResponse(
            $this->bookFacade->create($book)
        );
    }

    #[Route('/{book}', name: 'update', methods: [Request::METHOD_PUT])]
    #[OAParameterPath('book'), OARequest(BookDto::class), OAResponse(BookDto::class), OAResponseValidation]
    public function update(
        Book $book,
        #[MapRequestPayload] BookDto $newBook,
    ): JsonResponse {
        return $this->okResponse(
            $this->bookFacade->update($book, $newBook)
        );
    }

    #[Route('/{book}', name: 'delete', methods: [Request::METHOD_DELETE])]
    #[OAParameterPath('book'), OAResponseDeleted]
    public function delete(Book $book): JsonResponse
    {
        $this->bookFacade->delete($book);

        return $this->deletedResponse();
    }
}
