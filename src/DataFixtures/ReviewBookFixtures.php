<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\ReviewFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReviewBookFixtures extends Fixture
{
    public const REVIEW_SIZE = 20;

    public function load(ObjectManager $manager): void
    {
        ReviewFactory::createMany(
            self::REVIEW_SIZE,
            ['book' => BookFactory::random()]
        );
    }
}
