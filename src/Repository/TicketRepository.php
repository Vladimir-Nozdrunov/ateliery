<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class TicketRepository extends EntityRepository
{
    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countCreatedTickets($id)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.creator = :id')
            ->setParameter(':id', $id)
            ->getQuery()->getSingleScalarResult();

    }

    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countOpenTickets($id)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->leftJoin('t.status', 'status')
            ->where('t.assignee = :id AND status = :status')
            ->setParameter(':id', $id)
            ->setParameter(':status', 'open')
            ->getQuery()->getSingleScalarResult();

    }

    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countClosedTickets($id)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->leftJoin('t.status', 'status')
            ->where('t.assignee = :id AND status = :status')
            ->setParameter(':id', $id)
            ->setParameter(':status', 'closed')
            ->getQuery()->getSingleScalarResult();

    }
}