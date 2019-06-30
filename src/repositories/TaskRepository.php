<?php

namespace app\repositories;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class TaskRepository
 * @package app\repositories
 */
class TaskRepository extends EntityRepository
{
    /**
     * @param int $page
     * @param int $size
     * @return Paginator
     */
    public function getPaginated(int $page, int $size): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.created', 'DESC')
            ->setFirstResult($size * ($page-1))
            ->setMaxResults($size);

        return new Paginator($query);
    }
}
