<?php

namespace App\Repository;

use App\Entity\Event;
use App\Enum\StatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return Event[] Returns an array of Event objects with status validated and date => now
     */
    public function findOpenAndValidated(): array
    {
        return $this->createQueryBuilder('event')
            ->where('event.status = :status')
            ->setParameter('status', StatusEnum::accepted)
            ->andWhere('event.dateTime >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('event.dateTime', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
