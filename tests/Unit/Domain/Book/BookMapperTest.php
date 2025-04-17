<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Book;

use App\Domain\Book\BookMapper;
use App\Tests\Factory\BookDtoFactory;
use App\Tests\Fixture\Entity\BookFixture;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class BookMapperTest extends TestCase
{
    use Factories;

    public function testCreateBookDto(): void
    {
        $bookDto = BookDtoFactory::new()->create();
        $book = BookFixture::createFromDto($bookDto);

        $this->assertEquals($bookDto->_real(), $this->createBookMapper()->createBookDto($book));
    }

    public function testCreateBook(): void
    {
        $bookDto = BookDtoFactory::new()->create();
        $book = BookFixture::createFromDto($bookDto)->setCategories(new ArrayCollection());

        $this->assertEquals($book, $this->createBookMapper()->createBook($bookDto));
    }

    public function testCreateBookDtoList(): void
    {
        $bookDtoList = BookDtoFactory::new()->createMany(BookDtoFactory::BOOK_LIST_SIZE);
        $books = [];
        $expected = [];

        foreach ($bookDtoList as $bookDto) {
            $books[] = BookFixture::createFromDto($bookDto);
            $expected[] = $bookDto->_real();
        }

        $this->assertEquals($expected, $this->createBookMapper()->createBookDtoList($books));
    }

    private function createBookMapper(): BookMapper
    {
        return new BookMapper();
    }
}
