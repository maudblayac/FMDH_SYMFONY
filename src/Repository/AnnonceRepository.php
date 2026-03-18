<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonce>
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /** @return Annonce[] */
    public function findByType(string $typeTransaction): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.typeTransaction = :type')
            ->setParameter('type', $typeTransaction)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /** @return Annonce[] */
    public function findByPropertyType(string $propertyType): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.propertyType = :ptype')
            ->setParameter('ptype', $propertyType)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
