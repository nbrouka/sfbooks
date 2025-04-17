<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerTest extends WebTestCase
{
    use JsonAssertions;

    protected ApiClient $apiClient;
    protected ?EntityManagerInterface $entityManager = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiClient = $this->createApiClient();
        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testApiDoc(): void
    {
        $this->apiClient->getClient()->request(Request::METHOD_GET, ApiClient::API_DOC);
        $this->assertResponseIsSuccessful();
    }

    private function createApiClient(): ApiClient
    {
        return new ApiClient(static::createClient());
    }
}
