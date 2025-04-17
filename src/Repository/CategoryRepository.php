<?php

namespace App\Repository;

use App\Entity\Category;
use App\Model\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Order;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Paginator<Category>
     */
    public function findAllSortedByTitle(int $page): Paginator
    {
        $query = $this->createQueryBuilder('category')
            ->orderBy('category.title', Order::Ascending->value);

        return new Paginator($query, $page);
    }

    /**
     * @param array<int> $ids
     *
     * @return Collection<int, Category>
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
