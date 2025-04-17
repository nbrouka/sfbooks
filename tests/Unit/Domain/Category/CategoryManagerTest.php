<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Category;

use App\Domain\Category\CategoryManager;
use App\Domain\Category\CategoryMapper;
use App\Model\Dto\CategoryDto;
use App\Model\Paginator;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Tests\Factory\BookDtoFactory;
use App\Tests\Factory\CategoryDtoFactory;
use App\Tests\Fixture\Entity\CategoryFixture;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

use function Zenstruck\Foundry\faker;

class CategoryManagerTest extends TestCase
{
    use Factories;

    private BookRepository|MockObject $bookRepository;
    private CategoryRepository|MockObject $categoryRepository;
    private CategoryMapper|MockObject $categoryMapper;
    private EntityManagerInterface|MockObject $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->categoryMapper = $this->createMock(CategoryMapper::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
    }

    /** @param array<int> $bookIds */
    #[DataProvider('bookIdsProvider')]
    public function testCreateCategory(array $bookIds): void
    {
        /** @var CategoryDto $categoryDto */
        $categoryDto = CategoryDtoFactory::new()->create();
        $categoryDto->setBookIds($bookIds);
        $category = CategoryFixture::createFromDto($categoryDto);

        $this->categoryMapper->expects($this->once())
            ->method('createCategory')
            ->with($categoryDto)
            ->willReturn($category);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($category);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->categoryMapper->expects($this->once())
            ->method('createCategoryDto')
            ->with($category)
            ->willReturn($categoryDto);

        $this->assertEquals($categoryDto, $this->createCategoryManager()->create($categoryDto));
    }

    /** @param array<int> $bookIds */
    #[DataProvider('bookIdsProvider')]
    public function testUpdateCategory(array $bookIds): void
    {
        /** @var CategoryDto $categoryDto */
        $categoryDto = CategoryDtoFactory::new()->create();
        $categoryDto->setBookIds($bookIds);
        $category = CategoryFixture::createFromDto($categoryDto);

        $this->categoryMapper->expects($this->once())
            ->method('createCategory')
            ->with($categoryDto)
            ->willReturn($category);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($category);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->categoryMapper->expects($this->once())
            ->method('createCategoryDto')
            ->with($category)
            ->willReturn($categoryDto);

        $this->assertEquals($categoryDto, $this->createCategoryManager()->update($category, $categoryDto));
    }

    public function testDeleteCategory(): void
    {
        /** @var CategoryDto $categoryDto */
        $categoryDto = CategoryDtoFactory::new()->create();

        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with(CategoryFixture::createFromDto($categoryDto));

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->assertTrue($this->createCategoryManager()->delete(CategoryFixture::createFromDto($categoryDto)));
    }

    public function testGetList(): void
    {
        $bookDtoList = CategoryDtoFactory::new()->createMany(CategoryDtoFactory::CATEGORY_LIST_SIZE);

        $this->categoryRepository->expects($this->once())
            ->method('findAllSortedByTitle')
            ->with(Paginator::FIRST_PAGE)
            ->willReturn($this->createMock(Paginator::class));

        $this->categoryMapper->expects($this->once())
            ->method('createCategoryDtoList')
            ->willReturn($bookDtoList);

        $this->assertEquals(
            $this->createMock(Paginator::class),
            $this->createCategoryManager()->list(Paginator::FIRST_PAGE)
        );
    }

    /** @return iterable<string, array<int, array<int>>> */
    public static function bookIdsProvider(): iterable
    {
        yield 'empty' => [[]];
        yield 'not empty' => [
            faker()
                ->randomElements(
                    range(
                        BookDtoFactory::START_ID,
                        BookDtoFactory::END_ID
                    ),
                    BookDtoFactory::BOOK_LIST_SIZE
                ),
        ];
    }

    private function createCategoryManager(): CategoryManager
    {
        return new CategoryManager(
            $this->categoryRepository,
            $this->bookRepository,
            $this->entityManager,
            $this->categoryMapper
        );
    }
}
