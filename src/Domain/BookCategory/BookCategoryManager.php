<?php

declare(strict_types=1);

namespace App\Domain\BookCategory;

use App\Domain\Book\BookMapper;
use App\Entity\Book;
use App\Entity\Category;
use App\Model\Paginator;
use App\Repository\BookRepository;

class BookCategoryManager
{
    public function __construct(
        private BookRepository $bookRepository,
        private BookMapper $bookMapper,
    ) {
    }

    /**
     * @return Paginator<Book>
     */
    public function getBooksByCategory(Category $category, int $page): Paginator
    {
        $result = $this->bookRepository->findByCategorySortedByTitle($category, $page);
        $bookDtoList = $this->bookMapper->createBookDtoList(
            $result->getData()
        );

        return $result->setData($bookDtoList);
    }
}
