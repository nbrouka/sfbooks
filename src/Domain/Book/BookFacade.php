<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Entity\Book;
use App\Model\Dto\BookDto;
use App\Model\Paginator;

class BookFacade
{
    public function __construct(
        private BookManager $manager,
    ) {
    }

    public function create(BookDto $book): BookDto
    {
        return $this->manager->create($book);
    }

    public function update(Book $book, BookDto $newBook): BookDto
    {
        return $this->manager->update($book, $newBook);
    }

    public function delete(Book $book): bool
    {
        return $this->manager->delete($book);
    }

    /**
     * @return Paginator<Book>
     */
    public function list(int $page): Paginator
    {
        return $this->manager->list($page);
    }
}
