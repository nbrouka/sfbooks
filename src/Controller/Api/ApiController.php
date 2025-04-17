<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    /** @param array<mixed>|object $data */
    protected function okResponse(array|object $data): JsonResponse
    {
        return $this->getResponse($data, JsonResponse::HTTP_OK);
    }

    protected function createdResponse(object $data): JsonResponse
    {
        return $this->getResponse($data, JsonResponse::HTTP_CREATED);
    }

    protected function deletedResponse(): JsonResponse
    {
        return $this->getResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    protected function processedResponse(): JsonResponse
    {
        return $this->getResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /** @param array<mixed>|object $data */
    protected function redirectResponse(array|object $data): JsonResponse
    {
        return $this->getResponse($data, JsonResponse::HTTP_TEMPORARY_REDIRECT);
    }

    /** @param array<mixed>|object|null $data */
    protected function getResponse(
        array|object|null $data,
        int $statusCode = JsonResponse::HTTP_OK,
    ): JsonResponse {
        return $this->json($data, $statusCode);
    }
}
