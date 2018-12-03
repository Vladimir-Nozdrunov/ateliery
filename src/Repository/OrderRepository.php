<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function ordersByUser($id)
    {
        $qb = $this->createQueryBuilder('o')
            ->join('o.client', 'client')
            ->where('client = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();

        return $qb;
    }
}