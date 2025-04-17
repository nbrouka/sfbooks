<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Review;
use App\Model\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findByBook(Book $book, int $page): Paginator
    {
        $query = $this->createQueryBuilder('review')
            ->where('review.book = :book')
            ->setParameter('book', $book->getId())
            ->orderBy('review.createdAt', Order::Descending->value);

        return new Paginator($query, $page);
    }

    public function getRatingSumByBook(Book $book): int
    {
        return $this->createQueryBuilder('review')
            ->select('SUM(review.rating)')
            ->where('review.book = :book')
            ->setParameter('book', $book->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}
