<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\Dto\BookDto;
use App\Model\Paginator;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookManager
{
    public function __construct(
        private BookRepository $bookRepository,
        private CategoryRepository $categoryRepository,
        private BookMapper $bookMapper,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(BookDto $bookDto): BookDto
    {
        $categories = $this->categoryRepository->findByIds($bookDto->getCategoryIds());
        $book = $this->bookMapper->createBook($bookDto);
        $book->setCategories($categories);

        /** @var Category $category */
        foreach ($categories as $category) {
            $category->addBook($book);
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->bookMapper->createBookDto($book);
    }

    public function update(Book $book, BookDto $newBook): BookDto
    {
        $categories = $this->categoryRepository->findByIds($newBook->getCategoryIds());
        $book = $this->bookMapper->createBook($newBook);
        $book->setCategories($categories);

        /** @var Category $category */
        foreach ($categories as $category) {
            $category->addBook($book);
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->bookMapper->createBookDto($book);
    }

    public function delete(Book $book): bool
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @return Paginator<Book>
     */
    public function list(int $page): Paginator
    {
        $result = $this->bookRepository->findAllSortedByTitle($page);
        $bookDtoList = $this->bookMapper->createBookDtoList(
            $result->getData()
        );

        return $result->setData($bookDtoList);
    }
}
