<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Book;

use App\Domain\Category\CategoryMapper;
use App\Tests\Factory\CategoryDtoFactory;
use App\Tests\Fixture\Entity\CategoryFixture;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class CategoryMapperTest extends TestCase
{
    use Factories;

    public function testCreateCategoryDto(): void
    {
        $categoryDto = CategoryDtoFactory::new()->create();
        $category = CategoryFixture::createFromDto($categoryDto);

        $this->assertEquals($categoryDto->_real(), $this->createCategoryMapper()->createCategoryDto($category));
    }

    public function testCreateCategory(): void
    {
        $categoryDto = CategoryDtoFactory::new()->create();
        $category = CategoryFixture::createFromDto($categoryDto)->setBooks(new ArrayCollection());

        $this->assertEquals($category, $this->createCategoryMapper()->createCategory($categoryDto));
    }

    public function testCreateCategoryDtoList(): void
    {
        $categoryDtoList = CategoryDtoFactory::new()->createMany(CategoryDtoFactory::BOOK_LIST_SIZE);
        $categories = [];
        $expected = [];

        foreach ($categoryDtoList as $categoryDto) {
            $categories[] = CategoryFixture::createFromDto($categoryDto);
            $expected[] = $categoryDto->_real();
        }

        $this->assertEquals($expected, $this->createCategoryMapper()->createCategoryDtoList($categories));
    }

    private function createCategoryMapper(): CategoryMapper
    {
        return new CategoryMapper();
    }
}
