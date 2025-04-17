<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Api;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

final class ApiClient
{
    public const API_PREFIX = '/api/v1/';
    public const API_DOC = '/api/doc';

    public function __construct(
        private KernelBrowser $client,
    ) {
    }

    /** @return array<string, mixed> */
    public function getOne(string $resource, int $id): array
    {
        $this->client->request(Request::METHOD_GET, self::API_PREFIX . $resource . '/' . $id);

        return json_decode(
            json: $this->client->getResponse()->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /** @return array<string, mixed> */
    public function getList(string $resource): array
    {
        $this->client->request(Request::METHOD_GET, self::API_PREFIX . $resource);

        return json_decode(
            json: $this->client->getResponse()->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function create(string $resource, array $data): array
    {
        $this->client->request(
            method: Request::METHOD_POST,
            uri: self::API_PREFIX . $resource,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($data, JSON_THROW_ON_ERROR)
        );

        return json_decode(
            json: $this->client->getResponse()->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function update(string $resource, int $id, array $data): array
    {
        $this->client->request(
            method: Request::METHOD_PUT,
            uri: self::API_PREFIX . $resource . '/' . $id,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($data, JSON_THROW_ON_ERROR)
        );

        return json_decode(
            json: $this->client->getResponse()->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

    public function delete(string $resource, int $id): void
    {
        $this->client->request(
            method: Request::METHOD_DELETE,
            uri: self::API_PREFIX . $resource . '/' . $id
        );
    }

    public function getClient(): KernelBrowser
    {
        return $this->client;
    }
}
