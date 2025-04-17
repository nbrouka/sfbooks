<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    public const RECOMMENDATIONS_PATH = '../wiremock/mappings/book-recommendation.json';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'home', methods: [Request::METHOD_GET])]
    public function home(): Response
    {
        return new Response();
    }

    #[Route('healthcheck', name: 'healthcheck', methods: [Request::METHOD_GET])]
    public function healthcheck(): Response
    {
        $status = Response::HTTP_OK;
        $services = [
            'database' => true,
        ];

        try {
            $this->entityManager->getConnection()->getNativeConnection();
        } catch (Exception $e) {
            $services['database'] = $e->getMessage();
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse($services, $status);
    }

    #[Route('recommendations', name: 'recommendations', methods: [Request::METHOD_GET])]
    public function getRecommendations(): JsonResponse
    {
        if (file_exists(self::RECOMMENDATIONS_PATH)) {
            $json = json_decode(file_get_contents(self::RECOMMENDATIONS_PATH));
            return new JsonResponse($json->response->jsonBody, Response::HTTP_OK);
        }

        return new JsonResponse(['error' => 'Recommendations not found'], Response::HTTP_NOT_FOUND);
    }
}
