<?php

namespace App\Repository;

use App\Entity\Emprunt;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    public function findActiveByLivre(Livre $livre): ?Emprunt
    {
        return $this->createQueryBuilder('e')
            ->where('e.livre = :livre')
            ->andWhere('e.date_retour_effective IS NULL')
            ->setParameter('livre', $livre)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
