<?php

declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\Controller\Api\ApiController;
use App\Model\Dto\SignUpRequestDto;
use App\Model\Error\ErrorResponse;
use App\Model\OpenApi\OAResponse;
use App\Service\AuthService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/auth', name: 'auth_')]
#[OA\Tag('Auth')]
final class AuthController extends ApiController
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    #[Route('/signUp', name: 'sign_up', methods: ['POST'])]
    #[OA\Response(description: 'Signs up a user', response: Response::HTTP_OK, content: new OA\JsonContent(properties: [
        new OA\Property(property: 'token', type: 'string'),
        new OA\Property(property: 'refreshToken', type: 'string'),
    ]))]
    #[OAResponse(
        description: 'User already exists',
        response: Response::HTTP_CONFLICT,
        attachables: [new Model(type: ErrorResponse::class)]
    )]
    #[OAResponse(
        description: 'Validation failed',
        response: Response::HTTP_BAD_REQUEST,
        attachables: [new Model(type: ErrorResponse::class)]
    )]
    #[OA\RequestBody(attachables: [new Model(type: SignUpRequestDto::class)])]
    public function signUp(#[MapRequestPayload] SignUpRequestDto $signUpRequestDto): Response
    {
        return $this->authService->signUp($signUpRequestDto);
    }
}
