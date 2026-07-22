<?php

namespace App\Repository;

use App\Entity\Emprunt;
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

    /**
     * @return Emprunt[]
     */
    public function findEnCours(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.rendu = false')
            ->orderBy('e.dateRetourPrevue', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
