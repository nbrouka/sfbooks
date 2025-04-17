<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Entity\Category;
use App\Model\Dto\CategoryDto;

class CategoryMapper
{
    public function createCategoryDto(Category $category): CategoryDto
    {
        return new CategoryDto(
            $category->getId(),
            $category->getTitle(),
            $category->getSlug(),
            $category->getBookIds(),
            $category->getCreatedAt()
        );
    }

    public function createCategory(CategoryDto $categoryDto): Category
    {
        return (new Category())
            ->setId($categoryDto->getId())
            ->setTitle($categoryDto->getTitle())
            ->setSlug($categoryDto->getSlug())
            ->setCreatedAt($categoryDto->getCreatedAt());
    }

    /**
     * @param array<Category> $categories
     *
     * @return array<CategoryDto>
     **/
    public function createCategoryDtoList(array $categories): array
    {
        return array_map([$this, 'createCategoryDto'], $categories);
    }
}
