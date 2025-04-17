<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Entity\Book;
use App\Model\Dto\BookDto;
use App\Model\Enum\BookLevel;
use App\Model\Enum\BookType;
use App\Model\Enum\ProgramLanguage;

class BookMapper
{
    public function createBookDto(Book $book): BookDto
    {
        return new BookDto(
            $book->getId(),
            $book->getTitle(),
            $book->getDescription(),
            $book->getLevel()->value,
            $book->getType()->value,
            $book->getLanguage()->value,
            $book->getIsbn(),
            $book->getCoverFileName(),
            $book->getPublished(),
            $book->getMeap(),
            $book->getCategoryIds(),
            $book->getCreatedAt()
        );
    }

    public function createBook(BookDto $bookDto): Book
    {
        return (new Book())
            ->setId($bookDto->getId())
            ->setTitle($bookDto->getTitle())
            ->setDescription($bookDto->getDescription())
            ->setLevel(BookLevel::from($bookDto->getLevel()))
            ->setType(BookType::from($bookDto->getType()))
            ->setLanguage(ProgramLanguage::from($bookDto->getLanguage()))
            ->setIsbn($bookDto->getIsbn())
            ->setPublished($bookDto->getPublished())
            ->setMeap($bookDto->getMeap())
            ->setCoverFileName($bookDto->getCoverFileName())
            ->setCreatedAt($bookDto->getCreatedAt());
    }

    /**
     * @param array<Book> $books
     *
     * @return array<BookDto>
     * */
    public function createBookDtoList(array $books): array
    {
        return array_map([$this, 'createBookDto'], $books);
    }
}
