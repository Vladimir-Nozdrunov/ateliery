<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getStuff()
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.roles != :role')
            ->setParameter(':role', 'ROLE_CLIENT')
            ->orderBy('u.department', 'DESC')
            ->getQuery()
            ->getResult();

        return $qb;
    }
}