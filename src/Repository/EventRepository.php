<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findFiltered($values = [], $limit = null)
    {
        $query = $this->createQueryBuilder('e')
            ->where('e.dateBegin > :date')
            ->setParameter('date', date('Y-m-d'))
            ->orderBy('e.dateBegin', 'ASC');

        if (!empty($limit)) {
            $query->setMaxResults($limit);
        }

        return $query->getQuery()
            ->execute();
    }
}
