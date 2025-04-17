<?php

namespace App\Tests\Factory;

use App\Entity\Book;
use App\Model\Enum\BookLevel;
use App\Model\Enum\BookType;
use App\Model\Enum\ProgramLanguage;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    public const MAX_LENGTH = 255;
    public const BOOK_LIST_SIZE = 10;

    public static function class(): string
    {
        return Book::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array|callable
    {
        return [
            'coverFileName' => self::faker()->url(),
            'description' => self::faker()->text(),
            'isbn' => self::faker()->isbn13(),
            'meap' => self::faker()->boolean(),
            'published' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'title' => self::faker()->text(self::MAX_LENGTH),
            'type' => self::faker()->randomElement(BookType::cases()),
            'level' => self::faker()->randomElement(BookLevel::cases()),
            'language' => self::faker()->randomElement(ProgramLanguage::cases()),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
