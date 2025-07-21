<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Dto;

use DateTimeImmutable;
use App\Model\Dto\CategoryDto;
use Zenstruck\Foundry\Test\Factories;

use function Zenstruck\Foundry\faker;

class CategoryDtoFixture
{
    use Factories;

    public const BOOK_LIST_SIZE = 3;
    public const START_ID = 1;
    public const END_ID = 200;
    public const MAX_LENGTH = 255;

    public static function get(): CategoryDto
    {
        return new CategoryDto(
            id: faker()->randomNumber(),
            title: faker()->text(self::MAX_LENGTH),
            slug: faker()->slug(),
            bookIds: faker()->randomElements(
                range(self::START_ID, self::END_ID),
                self::BOOK_LIST_SIZE
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
            'slug' => faker()->slug(),
            'bookIds' => faker()->randomElements(
                range(self::START_ID, self::END_ID),
                self::BOOK_LIST_SIZE
            ),
            'createdAt' => DateTimeImmutable::createFromMutable(faker()->dateTime())->format('Y-m-d H:i:s'),
        ];
    }

    /** @return array<string, mixed> */
    public static function toArray(CategoryDto $categoryDto): array
    {
        return [
            'id' => $categoryDto->getId(),
            'title' => $categoryDto->getTitle(),
            'slug' => $categoryDto->getSlug(),
            'bookIds' => $categoryDto->getBookIds(),
            'createdAt' => $categoryDto->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
