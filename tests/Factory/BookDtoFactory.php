<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Model\Dto\BookDto;
use App\Model\Enum\BookLevel;
use App\Model\Enum\BookType;
use App\Model\Enum\ProgramLanguage;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BookDto>
 */
final class BookDtoFactory extends PersistentProxyObjectFactory
{
    public const CATEGORY_LIST_SIZE = 3;
    public const START_ID = 1;
    public const END_ID = 200;
    public const MAX_LENGTH = 255;
    public const BOOK_LIST_SIZE = 10;

    public static function class(): string
    {
        return BookDto::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array|callable
    {
        return [
            'id' => self::faker()->randomNumber(),
            'coverFileName' => self::faker()->url(),
            'description' => self::faker()->text(),
            'isbn' => self::faker()->isbn13(),
            'meap' => self::faker()->boolean(),
            'published' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'title' => self::faker()->text(self::MAX_LENGTH),
            'type' => self::faker()->randomElement(BookType::cases())->value,
            'language' => self::faker()->randomElement(ProgramLanguage::cases())->value,
            'level' => self::faker()->randomElement(BookLevel::cases())->value,
            'categoryIds' => self::faker()->randomElements(
                range(self::START_ID, self::END_ID),
                self::CATEGORY_LIST_SIZE
            ),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
