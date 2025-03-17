<?php

namespace App\Repository;

use App\Entity\Bar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bar>
 */
class BarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bar::class);
    }

    public function findOneBarById(int $id): ?array
    {
        $findOneBar = $this->createQueryBuilder('bar')
            ->select('bar.id, bar.name, bar.description, user.address, bar.postalCode, bar.city, bar.telephone')
            ->where('bar.id = :id')
            ->setParameter('id', $id);

        try {
            return $findOneBar
                ->getQuery()
                ->getOneOrNullResult();
        } catch (\Exception $exception) {
            return [];
        }
    }
}
