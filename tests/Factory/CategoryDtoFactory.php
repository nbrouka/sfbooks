<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use DateTimeImmutable;
use App\Model\Dto\CategoryDto;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<CategoryDto>
 */
final class CategoryDtoFactory extends PersistentProxyObjectFactory
{
    public const BOOK_LIST_SIZE = 3;
    public const START_ID = 1;
    public const END_ID = 200;
    public const MAX_LENGTH = 255;
    public const CATEGORY_LIST_SIZE = 10;

    public static function class(): string
    {
        return CategoryDto::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'id' => self::faker()->randomNumber(),
            'title' => self::faker()->text(self::MAX_LENGTH),
            'slug' => self::faker()->text(self::MAX_LENGTH),
            'bookIds' => self::faker()->randomElements(range(self::START_ID, self::END_ID), self::BOOK_LIST_SIZE),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }
}
