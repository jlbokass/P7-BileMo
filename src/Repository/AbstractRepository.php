<?php


namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 10, $offset = 0)
    {
        if (0 === $limit || 0 === $offset) {
            throw new \LogicException('This limit & offset must greter than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $currentPage = ceil(($offset + 1)/ $limit);
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage((int)$limit);

        return $pager;
    }
}