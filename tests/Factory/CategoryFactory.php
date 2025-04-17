<?php

namespace App\Tests\Factory;

use App\Entity\Category;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Category>
 */
final class CategoryFactory extends PersistentProxyObjectFactory
{
    public const MAX_LENGTH = 255;
    public const CATEGORY_LIST_SIZE = 10;

    public static function class(): string
    {
        return Category::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array|callable
    {
        return [
            'slug' => self::faker()->text(self::MAX_LENGTH),
            'title' => self::faker()->text(self::MAX_LENGTH),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
