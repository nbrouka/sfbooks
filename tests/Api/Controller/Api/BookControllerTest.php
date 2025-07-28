<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Api;

use App\Model\Enum\BookLevel;
use App\Model\Enum\BookType;
use App\Model\Enum\ProgramLanguage;
use App\Tests\Factory\BookFactory;
use App\Tests\Fixture\Dto\BookDtoFixture;
use App\Tests\Fixture\Json\BookJsonResponseSchema;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

class BookControllerTest extends ApiControllerTest
{
    use Factories;

    public const RESOURCE = 'book';
    public const NOT_VALID_ISBN_MESSAGE = 'The value "not valid isbn" is not a valid ISBN-13.';
    public const NOT_VALID_LEVEL_MESSAGE = 'The value "not valid level" is not a valid book level: ';
    public const NOT_VALID_TYPE_MESSAGE = 'The value "not valid type" is not a valid book type: ';
    public const NOT_VALID_LANGUAGE_MESSAGE = 'The value "not valid language" is not a valid program language: ';

    public function testGetOne(): void
    {
        $book = BookFactory::new()->create();
        $responseContent = $this->apiClient->getOne(self::RESOURCE, $book->getId());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, BookJsonResponseSchema::getOne());
    }

    public function testGetList(): void
    {
        BookFactory::new()->createMany(BookFactory::BOOK_LIST_SIZE);
        $responseContent = $this->apiClient->getList(self::RESOURCE);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, BookJsonResponseSchema::getList());
    }

    public function testCreate(): void
    {
        $responseContent = $this->apiClient->create(self::RESOURCE, BookDtoFixture::getArray());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, BookJsonResponseSchema::getOne());
    }

    public function testUpdate(): void
    {
        $book = BookFactory::new()->create();
        $responseContent = $this->apiClient->update(self::RESOURCE, $book->getId(), BookDtoFixture::getArray());

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, BookJsonResponseSchema::getOne());
    }

    public function testDelete(): void
    {
        $book = BookFactory::new()->create();
        $this->apiClient->delete(self::RESOURCE, $book->getId());

        $this->assertResponseIsSuccessful();
    }

    /** @param array<string, mixed> $bookDto */
    #[DataProvider('bookDtoProvider')]
    public function testCreateInvalidBook(array $bookDto, string $message): void
    {
        $responseContent = $this->apiClient->create(self::RESOURCE, $bookDto);

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertEquals($message, $responseContent['message']);
    }

    /** @return iterable<string, array<int, array<string, mixed>|string>> */
    public static function bookDtoProvider(): iterable
    {
        $bookDto = BookDtoFixture::get();
        yield 'not valid isbn' => [
            BookDtoFixture::toArray($bookDto->setIsbn('not valid isbn')),
            self::NOT_VALID_ISBN_MESSAGE,
        ];
        $bookDto = BookDtoFixture::get();
        yield 'not valid level' => [
            BookDtoFixture::toArray($bookDto->setLevel('not valid level')),
            self::NOT_VALID_LEVEL_MESSAGE . self::valuesToString(BookLevel::getValues()) . '.',
        ];
        $bookDto = BookDtoFixture::get();
        yield 'not valid type' => [
            BookDtoFixture::toArray($bookDto->setType('not valid type')),
            self::NOT_VALID_TYPE_MESSAGE . self::valuesToString(BookType::getValues()) . '.',
        ];
        $bookDto = BookDtoFixture::get();
        yield 'not valid language' => [
            BookDtoFixture::toArray($bookDto->setLanguage('not valid language')),
            self::NOT_VALID_LANGUAGE_MESSAGE . self::valuesToString(ProgramLanguage::getValues()) . '.',
        ];
    }

    /** @param array<int, string> $values */
    private static function valuesToString(array $values): string
    {
        return implode(', ', array_map(fn (string $value) => '"' . $value . '"', $values));
    }
}
