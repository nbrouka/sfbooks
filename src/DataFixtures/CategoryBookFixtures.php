<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryBookFixtures extends Fixture
{
    public const CATEGORY_SIZE = 50;
    public const BOOK_SIZE = 100;

    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createMany(
            self::CATEGORY_SIZE,
            ['books' => BookFactory::new()->many(self::BOOK_SIZE)]
        );

        CategoryFactory::new()
            ->many(self::CATEGORY_SIZE)
            ->create(function () {
                return ['books' => BookFactory::randomRange(0, self::BOOK_SIZE)];
            });
    }
}
