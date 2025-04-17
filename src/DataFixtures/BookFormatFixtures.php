<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\BookFormatFactory;
use App\Factory\FormatFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFormatFixtures extends Fixture
{
    public const BOOK_SIZE = 20;
    public const FORMAT_SIZE = 20;
    public const BOOK_FORMAT_SIZE = 10;

    public function load(ObjectManager $manager): void
    {
        BookFactory::createMany(
            self::BOOK_SIZE,
            ['bookFormats' => BookFormatFactory::new()->many(self::BOOK_FORMAT_SIZE)]
        );

        BookFactory::new()
            ->many(self::BOOK_SIZE)
            ->create(function () {
                return ['bookFormats' => BookFormatFactory::randomRange(0, self::BOOK_FORMAT_SIZE)];
            });

        FormatFactory::createMany(
            self::FORMAT_SIZE,
            ['bookFormats' => BookFormatFactory::new()->many(self::BOOK_FORMAT_SIZE)]
        );

        FormatFactory::new()
            ->many(self::FORMAT_SIZE)
            ->create(function () {
                return ['bookFormats' => BookFormatFactory::randomRange(0, self::BOOK_FORMAT_SIZE)];
            });
    }
}
