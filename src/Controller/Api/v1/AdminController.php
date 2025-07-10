<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Entity\User;
use App\Model\Error\ErrorResponse;
use App\Model\OpenApi\OAResponse;
use App\Service\RoleService;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/admin', name: 'admin_')]
class AdminController extends ApiController
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {
    }

    #[Route('/grantAuthor/{user}', name: 'grant_author', methods: ['POST'])]
    #[OA\Tag(name: 'Admin API')]
    #[OAResponse(description: 'Author role granted')]
    #[OAResponse(
        description: 'User not found',
        response: Response::HTTP_NOT_FOUND,
        attachables: [new Model(type: ErrorResponse::class)]
    )]
    public function grantAuthor(User $user): JsonResponse
    {
        $this->roleService->grantAuthor($user->getId());

        return $this->okResponse([]);
    }
}
