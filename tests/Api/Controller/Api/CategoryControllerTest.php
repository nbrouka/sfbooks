<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Api;

use App\Tests\Factory\CategoryFactory;
use App\Tests\Fixture\Dto\CategoryDtoFixture;
use App\Tests\Fixture\Json\CategoryJsonResponseSchema;
use Zenstruck\Foundry\Test\Factories;

class CategoryControllerTest extends ApiControllerTest
{
    use Factories;

    public const RESOURCE = 'category';

    public function testGetOne(): void
    {
        $category = CategoryFactory::new()->create();
        $responseContent = $this->apiClient->getOne(self::RESOURCE, $category->getId());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, CategoryJsonResponseSchema::getOne());
    }

    public function testGetList(): void
    {
        CategoryFactory::new()->createMany(CategoryFactory::CATEGORY_LIST_SIZE);
        $responseContent = $this->apiClient->getList(self::RESOURCE);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, CategoryJsonResponseSchema::getList());
    }

    public function testCreate(): void
    {
        $responseContent = $this->apiClient->create(self::RESOURCE, CategoryDtoFixture::getArray());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, CategoryJsonResponseSchema::getOne());
    }

    public function testUpdate(): void
    {
        $book = CategoryFactory::new()->create();
        $responseContent = $this->apiClient->update(self::RESOURCE, $book->getId(), CategoryDtoFixture::getArray());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, CategoryJsonResponseSchema::getOne());
    }

    public function testDelete(): void
    {
        $book = CategoryFactory::new()->create();
        $this->apiClient->delete(self::RESOURCE, $book->getId());

        $this->assertResponseIsSuccessful();
    }
}
