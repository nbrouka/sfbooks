<?php

namespace App\Factory;

use App\Entity\BookFormat;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BookFormat>
 */
final class BookFormatFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return BookFormat::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'price' => self::faker()->randomNumber() / 100,
            'discountPercent' => self::faker()->randomNumber(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
