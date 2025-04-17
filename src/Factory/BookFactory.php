<?php

declare(strict_types=1);

namespace App\Factory;

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
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Book::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'coverFileName' => self::faker()->url(),
            'description' => self::faker()->text(),
            'isbn' => self::faker()->isbn13(),
            'meap' => self::faker()->boolean(),
            'published' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'title' => self::faker()->text(50),
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
