<?php

namespace App\Repository;

use App\Entity\Band;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Band>
 */
class BandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Band::class);
    }

    public function getAll(): ?array
    {
        $getAllBar = $this->createQueryBuilder('band')
            ->select('band.id, band.name, band.description');

        try {
            return $getAllBar
                ->getQuery()
                ->getArrayResult();
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function findOneBarById(int $id): ?array
    {
        $findOneBand = $this->createQueryBuilder('band')
            ->select('band.id, band.name, band.description')
            ->where('band.id = :id')
            ->setParameter('id', $id);

        try {
            return $findOneBand
                ->getQuery()
                ->getOneOrNullResult();
        } catch (\Exception $exception) {
            return [];
        }
    }
}
