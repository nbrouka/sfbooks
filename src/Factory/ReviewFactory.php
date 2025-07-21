<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Review;
use DateTimeImmutable;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Review>
 */
class ReviewFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Review::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'content' => self::faker()->text(100),
            'rating' => self::faker()->randomNumber(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
