<?php

namespace App\Factory;

use DateTimeImmutable;
use App\Entity\Subscription;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Subscription>
 */
final class SubscriptionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Subscription::class;
    }

    /** @return array<string, mixed> */
    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->text(255),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
