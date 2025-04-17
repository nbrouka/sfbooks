<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Book;

use App\Domain\Book\BookManager;
use App\Domain\Book\BookMapper;
use App\Model\Dto\BookDto;
use App\Model\Paginator;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Tests\Factory\BookDtoFactory;
use App\Tests\Fixture\Entity\BookFixture;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

use function Zenstruck\Foundry\faker;

class BookManagerTest extends TestCase
{
    use Factories;

    private BookRepository|MockObject $bookRepository;
    private CategoryRepository|MockObject $categoryRepository;
    private BookMapper|MockObject $bookMapper;
    private EntityManagerInterface|MockObject $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->bookMapper = $this->createMock(BookMapper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
    }

    /** @param array<int> $categoryIds */
    #[DataProvider('categoryIdsProvider')]
    public function testCreateBook(array $categoryIds): void
    {
        /** @var BookDto $bookDto */
        $bookDto = BookDtoFactory::new()->create();
        $bookDto->setCategoryIds($categoryIds);
        $book = BookFixture::createFromDto($bookDto);

        $this->bookMapper->expects($this->once())
            ->method('createBook')
            ->with($bookDto)
            ->willReturn($book);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($book);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->bookMapper->expects($this->once())
            ->method('createBookDto')
            ->with($book)
            ->willReturn($bookDto);

        $this->assertEquals($bookDto, $this->createBookManager()->create($bookDto));
    }

    /** @param array<int> $categoryIds */
    #[DataProvider('categoryIdsProvider')]
    public function testUpdateBook(array $categoryIds): void
    {
        /** @var BookDto $bookDto */
        $bookDto = BookDtoFactory::new()->create();
        $bookDto->setCategoryIds($categoryIds);
        $book = BookFixture::createFromDto($bookDto);

        $this->bookMapper->expects($this->once())
            ->method('createBook')
            ->with($bookDto)
            ->willReturn($book);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($book);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->bookMapper->expects($this->once())
            ->method('createBookDto')
            ->with($book)
            ->willReturn($bookDto);

        $this->assertEquals($bookDto, $this->createBookManager()->update($book, $bookDto));
    }

    public function testDeleteBook(): void
    {
        /** @var BookDto $bookDto */
        $bookDto = BookDtoFactory::new()->create();

        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with(BookFixture::createFromDto($bookDto));

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->assertTrue($this->createBookManager()->delete(BookFixture::createFromDto($bookDto)));
    }

    public function testGetList(): void
    {
        $bookDtoList = BookDtoFactory::new()->createMany(BookDtoFactory::BOOK_LIST_SIZE);

        $this->bookRepository->expects($this->once())
            ->method('findAllSortedByTitle')
            ->with(Paginator::FIRST_PAGE)
            ->willReturn($this->createMock(Paginator::class));

        $this->bookMapper->expects($this->once())
            ->method('createBookDtoList')
            ->willReturn($bookDtoList);

        $this->assertEquals(
            $this->createMock(Paginator::class),
            $this->createBookManager()->list(Paginator::FIRST_PAGE)
        );
    }

    /** @return iterable<string, array<int, array<int>>> */
    public static function categoryIdsProvider(): iterable
    {
        yield 'empty' => [[]];
        yield 'not empty' => [
            faker()
                ->randomElements(
                    range(
                        BookDtoFactory::START_ID,
                        BookDtoFactory::END_ID
                    ),
                    BookDtoFactory::CATEGORY_LIST_SIZE
                ),
        ];
    }

    private function createBookManager(): BookManager
    {
        return new BookManager(
            $this->bookRepository,
            $this->categoryRepository,
            $this->bookMapper,
            $this->entityManager
        );
    }
}
