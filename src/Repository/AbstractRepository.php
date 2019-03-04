<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 20)
    {

        if (0 == $limit) {
            throw new \LogicException('$limit must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $currentPage = ceil(1) / $limit;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $pager->setCurrentPage((int)$currentPage);
        $pager->setMaxPerPage((int) $limit);
        return $pager;
    }
}
