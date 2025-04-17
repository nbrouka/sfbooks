<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Domain\Category\CategoryFacade;
use App\Domain\Category\CategoryMapper;
use App\Entity\Category;
use App\Model\Dto\CategoryDto;
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

#[Route('api/v1/category', name: 'category')]
#[OA\Tag('Category')]
final class CategoryController extends ApiController
{
    public function __construct(
        private CategoryFacade $categoryFacade,
        private CategoryMapper $categoryMapper,
    ) {
    }

    #[Route('/{category}', name: 'get_one', requirements: ['category' => '\d+'], methods: [Request::METHOD_GET])]
    #[OAParameterPath('category'), OAResponse(CategoryDto::class)]
    public function getOne(Category $category): JsonResponse
    {
        return $this->okResponse($this->categoryMapper->createCategoryDto($category));
    }

    #[Route('', name: 'get_list', methods: [Request::METHOD_GET])]
    #[OAParameterQuery('page', 'Pagination parameter'), OAResponse([CategoryDto::class])]
    public function getList(Request $request, PaginatorOptionsResolver $resolver): JsonResponse
    {
        try {
            $queryParams = $resolver
                ->configurePage()
                ->resolve($request->query->all());

            return $this->okResponse($this->categoryFacade->list($queryParams['page'] ?? Paginator::FIRST_PAGE));
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    #[Route('', name: 'create', methods: [Request::METHOD_POST])]
    #[OARequest(CategoryDto::class), OAResponseCreated(CategoryDto::class), OAResponseValidation]
    public function create(#[MapRequestPayload] CategoryDto $category): JsonResponse
    {
        return $this->createdResponse(
            $this->categoryFacade->create($category)
        );
    }

    #[Route('/{category}', name: 'update', methods: [Request::METHOD_PUT])]
    #[OAParameterPath('category'), OARequest(CategoryDto::class), OAResponse(CategoryDto::class), OAResponseValidation]
    public function update(
        Category $category,
        #[MapRequestPayload] CategoryDto $newCategory,
    ): JsonResponse {
        return $this->okResponse(
            $this->categoryFacade->update($category, $newCategory)
        );
    }

    #[Route('/{category}', name: 'delete', methods: [Request::METHOD_DELETE])]
    #[OAParameterPath('category'), OAResponseDeleted]
    public function delete(Category $category): JsonResponse
    {
        $this->categoryFacade->delete($category);

        return $this->deletedResponse();
    }
}
