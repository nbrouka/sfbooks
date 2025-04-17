<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Book;

use App\Domain\Book\BookFacade;
use App\Domain\Book\BookManager;
use App\Model\Paginator;
use App\Tests\Factory\BookDtoFactory;
use App\Tests\Fixture\Entity\BookFixture;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class BookFacadeTest extends TestCase
{
    use Factories;

    private BookManager|MockObject $bookManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookManager = $this->createMock(BookManager::class);
    }

    public function testCreate(): void
    {
        $bookDto = BookDtoFactory::new()->create();

        $this->bookManager->expects($this->once())
            ->method('create')
            ->with($bookDto)
            ->willReturn($bookDto);

        $this->assertEquals($bookDto, $this->createBookFacade()->create($bookDto));
    }

    public function testUpdate(): void
    {
        $bookDto = BookDtoFactory::new()->create();
        $book = BookFixture::createFromDto($bookDto);

        $this->bookManager->expects($this->once())
            ->method('update')
            ->with($book, $bookDto)
            ->willReturn($bookDto);

        $this->assertEquals($bookDto, $this->createBookFacade()->update($book, $bookDto));
    }

    public function testDelete(): void
    {
        $bookDto = BookDtoFactory::new()->create();
        $book = BookFixture::createFromDto($bookDto);

        $this->bookManager->expects($this->once())
            ->method('delete')
            ->with($book);

        $this->createBookFacade()->delete($book);
    }

    public function testGetList(): void
    {
        $this->bookManager->expects($this->once())
            ->method('list')
            ->with(Paginator::FIRST_PAGE)
            ->willReturn($this->createMock(Paginator::class));

        $this->assertEquals(
            $this->createMock(Paginator::class),
            $this->createBookFacade()->list(Paginator::FIRST_PAGE)
        );
    }

    private function createBookFacade(): BookFacade
    {
        return new BookFacade($this->bookManager);
    }
}
