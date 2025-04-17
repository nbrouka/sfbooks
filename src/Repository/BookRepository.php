<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Category;
use App\Model\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Order;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Paginator<Book>
     */
    public function findAllSortedByTitle(int $page): Paginator
    {
        $query = $this->createQueryBuilder('book')->orderBy('book.title', Order::Ascending->value);

        return new Paginator($query, $page);
    }

    /**
     * @return Paginator<Book>
     */
    public function findByCategorySortedByTitle(Category $category, int $page): Paginator
    {
        $query = $this->createQueryBuilder('book')
            ->leftJoin('book.categories', 'category')
            ->addSelect('category')
            ->andWhere('category = :category')
            ->setParameter('category', $category->getId())
            ->orderBy('book.title', Order::Ascending->value);

        return new Paginator($query, $page);
    }

    /**
     * @param array<int> $ids
     *
     * @return Collection<int, Book>
     */
    public function findByIds(array $ids): Collection
    {
        return $this->matching(
            new Criteria(
                Criteria::expr()->in('id', $ids)
            )
        );
    }
}
