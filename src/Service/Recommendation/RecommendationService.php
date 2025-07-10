<?php

declare(strict_types=1);

namespace App\Service\Recommendation;

use Throwable;
use App\Entity\Book;
use App\Exception\RequestException;
use App\Exception\AccessDeniedException;
use App\Model\Dto\RecommendationResponseDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\ClientException;

class RecommendationService
{
    public function __construct(
        private readonly HttpClientInterface $recommendationClient,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function getRecommendationsByBook(Book $book): RecommendationResponseDto
    {
        try {
            $url = '/book/' . $book->getId() . '/recommendations';
            $response = $this->recommendationClient->request(Request::METHOD_GET, $url);

            return $this->serializer->deserialize(
                $response->getContent(),
                RecommendationResponseDto::class,
                JsonEncoder::FORMAT
            );
        } catch (Throwable $exception) {
            if ($exception instanceof ClientException && Response::HTTP_FORBIDDEN === $exception->getCode()) {
                throw new AccessDeniedException($exception->getMessage(), $exception);
            }

            throw new RequestException($exception->getMessage(), $exception);
        }
    }
}
