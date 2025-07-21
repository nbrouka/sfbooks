<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Dto;

use DateTimeImmutable;
use App\Model\Dto\BookDto;
use App\Model\Enum\BookType;
use App\Model\Enum\BookLevel;
use App\Model\Enum\ProgramLanguage;
use Zenstruck\Foundry\Test\Factories;

use function Zenstruck\Foundry\faker;

class BookDtoFixture
{
    use Factories;

    public const CATEGORY_LIST_SIZE = 3;
    public const START_ID = 1;
    public const END_ID = 200;
    public const MAX_LENGTH = 255;

    public static function get(): BookDto
    {
        return new BookDto(
            id: faker()->randomNumber(),
            title: faker()->text(self::MAX_LENGTH),
            description: faker()->text(),
            level: faker()->randomElement(BookLevel::cases())->value,
            type: faker()->randomElement(BookType::cases())->value,
            language: faker()->randomElement(ProgramLanguage::cases())->value,
            isbn: faker()->isbn13(),
            coverFileName: faker()->url(),
            published: DateTimeImmutable::createFromMutable(faker()->dateTime()),
            meap: faker()->boolean(),
            categoryIds: faker()->randomElements(
                range(self::START_ID, self::END_ID),
                self::CATEGORY_LIST_SIZE
            ),
            createdAt: DateTimeImmutable::createFromMutable(faker()->dateTime()),
        );
    }

    /** @return array<string, mixed> */
    public static function getArray(): array
    {
        return [
            'id' => faker()->randomNumber(),
            'title' => faker()->text(self::MAX_LENGTH),
            'description' => faker()->text(),
            'level' => faker()->randomElement(BookLevel::cases())->value,
            'type' => faker()->randomElement(BookType::cases())->value,
            'language' => faker()->randomElement(ProgramLanguage::cases())->value,
            'isbn' => faker()->isbn13(),
            'coverFileName' => faker()->url(),
            'published' => DateTimeImmutable::createFromMutable(faker()->dateTime())->format('Y-m-d H:i:s'),
            'meap' => faker()->boolean(),
            'categoryIds' => faker()->randomElements(
                range(self::START_ID, self::END_ID),
                self::CATEGORY_LIST_SIZE
            ),
            'createdAt' => DateTimeImmutable::createFromMutable(faker()->dateTime())->format('Y-m-d H:i:s'),
        ];
    }

    /** @return array<string, mixed> */
    public static function toArray(BookDto $bookDto): array
    {
        return [
            'id' => $bookDto->getId(),
            'title' => $bookDto->getTitle(),
            'description' => $bookDto->getDescription(),
            'level' => $bookDto->getLevel(),
            'type' => $bookDto->getType(),
            'language' => $bookDto->getLanguage(),
            'isbn' => $bookDto->getIsbn(),
            'coverFileName' => $bookDto->getCoverFileName(),
            'published' => $bookDto->getPublished()->format('Y-m-d H:i:s'),
            'meap' => $bookDto->getMeap(),
            'categoryIds' => $bookDto->getCategoryIds(),
            'createdAt' => $bookDto->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
