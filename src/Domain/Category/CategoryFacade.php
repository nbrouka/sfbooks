<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Entity\Category;
use App\Model\Dto\CategoryDto;
use App\Model\Paginator;

final class CategoryFacade
{
    public function __construct(
        private CategoryManager $manager,
    ) {
    }

    public function create(CategoryDto $category): CategoryDto
    {
        return $this->manager->create($category);
    }

    public function update(Category $category, CategoryDto $newCategory): CategoryDto
    {
        return $this->manager->update($category, $newCategory);
    }

    public function delete(Category $category): bool
    {
        return $this->manager->delete($category);
    }

    /**
     * @return Paginator<Category>
     */
    public function list(int $page): Paginator
    {
        return $this->manager->list($page);
    }
}
