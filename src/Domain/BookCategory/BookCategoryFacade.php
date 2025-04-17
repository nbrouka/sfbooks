<?php

declare(strict_types=1);

namespace App\Domain\BookCategory;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\Paginator;

class BookCategoryFacade
{
    public function __construct(
        private BookCategoryManager $bookCategoryManager,
    ) {
    }

    /**
     * @return Paginator<Book>
     */
    public function getBooksByCategory(Category $category, int $page): Paginator
    {
        return $this->bookCategoryManager->getBooksByCategory($category, $page);
    }
}
