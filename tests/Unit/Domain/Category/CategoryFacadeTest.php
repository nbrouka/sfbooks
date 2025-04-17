<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Book;

use App\Domain\Category\CategoryFacade;
use App\Domain\Category\CategoryManager;
use App\Model\Paginator;
use App\Tests\Factory\CategoryDtoFactory;
use App\Tests\Fixture\Entity\CategoryFixture;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class CategoryFacadeTest extends TestCase
{
    use Factories;

    private CategoryManager|MockObject $categoryManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryManager = $this->createMock(CategoryManager::class);
    }

    public function testCreate(): void
    {
        $categoryDto = CategoryDtoFactory::new()->create();

        $this->categoryManager->expects($this->once())
            ->method('create')
            ->with($categoryDto)
            ->willReturn($categoryDto);

        $this->assertEquals($categoryDto, $this->createCategoryFacade()->create($categoryDto));
    }

    public function testUpdate(): void
    {
        $categoryDto = CategoryDtoFactory::new()->create();
        $category = CategoryFixture::createFromDto($categoryDto);

        $this->categoryManager->expects($this->once())
            ->method('update')
            ->with($category, $categoryDto)
            ->willReturn($categoryDto);

        $this->assertEquals($categoryDto, $this->createCategoryFacade()->update($category, $categoryDto));
    }

    public function testDelete(): void
    {
        $categoryDto = CategoryDtoFactory::new()->create();
        $category = CategoryFixture::createFromDto($categoryDto);

        $this->categoryManager->expects($this->once())
            ->method('delete')
            ->with($category);

        $this->createCategoryFacade()->delete($category);
    }

    public function testGetList(): void
    {
        $this->categoryManager->expects($this->once())
            ->method('list')
            ->with(Paginator::FIRST_PAGE)
            ->willReturn($this->createMock(Paginator::class));

        $this->assertEquals(
            $this->createMock(Paginator::class),
            $this->createCategoryFacade()->list(Paginator::FIRST_PAGE)
        );
    }

    private function createCategoryFacade(): CategoryFacade
    {
        return new CategoryFacade($this->categoryManager);
    }
}
