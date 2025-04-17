<?php

namespace App\Factory;

use App\Entity\Format;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Format>
 */
final class FormatFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Format::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array|callable
    {
        return [
            'title' => self::faker()->text(255),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'description' => self::faker()->text(255),
            'comment' => self::faker()->text(255),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
