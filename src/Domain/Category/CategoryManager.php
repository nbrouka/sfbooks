<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\Dto\CategoryDto;
use App\Model\Paginator;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryManager
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private BookRepository $bookRepository,
        private EntityManagerInterface $entityManager,
        private CategoryMapper $categoryMapper,
    ) {
    }

    public function create(CategoryDto $categoryDto): CategoryDto
    {
        $books = $this->bookRepository->findByIds($categoryDto->getBookIds());
        $category = $this->categoryMapper->createCategory($categoryDto);
        $category->setBooks($books);

        /** @var Book $book */
        foreach ($books as $book) {
            $book->addCategory($category);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $this->categoryMapper->createCategoryDto($category);
    }

    public function update(Category $category, CategoryDto $newCategory): CategoryDto
    {
        $books = $this->bookRepository->findByIds($newCategory->getBookIds());
        $category = $this->categoryMapper->createCategory($newCategory);
        $category->setBooks($books);

        /** @var Book $book */
        foreach ($books as $book) {
            $book->addCategory($category);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $this->categoryMapper->createCategoryDto($category);
    }

    public function delete(Category $category): bool
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Paginator<Category>
     */
    public function list(int $page): Paginator
    {
        $result = $this->categoryRepository->findAllSortedByTitle($page);
        $categoryDtoList = $this->categoryMapper->createCategoryDtoList(
            $result->getData()
        );

        return $result->setData($categoryDtoList);
    }
}
