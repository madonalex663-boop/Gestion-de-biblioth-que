<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * Recherche un livre par titre, nom d'auteur ou nom de catégorie.
     *
     * @return Livre[]
     */
    public function search(?string $terme): array
    {
        if (!$terme) {
            return $this->findAll();
        }

        return $this->createQueryBuilder('l')
            ->leftJoin('l.auteur', 'a')
            ->addSelect('a')
            ->leftJoin('l.categorie', 'c')
            ->addSelect('c')
            ->where('l.titre LIKE :terme')
            ->orWhere('a.nom LIKE :terme')
            ->orWhere('a.prenom LIKE :terme')
            ->orWhere('c.nom LIKE :terme')
            ->orWhere('l.isbn LIKE :terme')
            ->setParameter('terme', '%' . $terme . '%')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
