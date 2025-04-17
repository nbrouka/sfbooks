<?php

declare(strict_types=1);

namespace App\Model;

use ArrayIterator;
use Doctrine\ORM\Query;
use DivisionByZeroError;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

/**
 * @template T
 *
 * @extends DoctrinePaginator<T>
 */
class Paginator extends DoctrinePaginator
{
    public const ITEMS_PER_PAGE = 10;
    public const FIRST_PAGE = 1;

    private int $total;
    /** @var array<mixed> */
    private array $data;
    private int $count;
    private int $totalPages;
    private int $page;

    public function __construct(QueryBuilder|Query $query, int $page = self::FIRST_PAGE, bool $fetchJoinCollection = true)
    {
        $query->setFirstResult(($page - self::FIRST_PAGE) * self::ITEMS_PER_PAGE);
        $query->setMaxResults(self::ITEMS_PER_PAGE);

        parent::__construct($query, $fetchJoinCollection);
        $this->total = $this->count();
        $this->data = iterator_to_array(parent::getIterator());
        $this->count = count($this->data);
        $this->page = $page;

        try {
            $this->totalPages = (int) ceil($this->total / self::ITEMS_PER_PAGE);
        } catch (DivisionByZeroError $e) {
            $this->totalPages = 0;
        }
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    /** @return array<mixed> */
    public function getData(): array
    {
        return $this->data;
    }

    /** @param array<mixed> $data */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }

    public function getItemsPerPage(): ?int
    {
        return $this->getQuery()->getMaxResults();
    }

    public function getOffset(): ?int
    {
        return $this->getQuery()->getFirstResult();
    }

    public function hasNextPage(): bool
    {
        if ($this->getCurrentPage() >= self::FIRST_PAGE && $this->getCurrentPage() < $this->getTotalPages()) {
            return true;
        }

        return false;
    }

    public function hasPreviousPage(): bool
    {
        if ($this->getCurrentPage() > self::FIRST_PAGE && $this->getCurrentPage() <= $this->getTotalPages()) {
            return true;
        }

        return false;
    }

    /**
     * @return ArrayIterator<string, array<mixed>>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator([
            'data' => $this->getData(),
            'pagination' => [
                'total' => $this->getTotal(),
                'count' => $this->getCount(),
                'offset' => $this->getOffset(),
                'items_per_page' => $this->getItemsPerPage(),
                'total_pages' => $this->getTotalPages(),
                'current_page' => $this->getCurrentPage(),
                'has_next_page' => $this->hasNextPage(),
                'has_previous_page' => $this->hasPreviousPage(),
            ],
        ]);
    }
}
