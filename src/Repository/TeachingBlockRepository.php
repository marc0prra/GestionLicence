<?php

namespace App\Repository;

use App\Entity\TeachingBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeachingBlock>
 */
class TeachingBlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeachingBlock::class);
    }

    // Requête pour filtrer les blocs d'enseignement
    public function findByFilters(?string $name, ?string $code): array
    {
        $filtre = $this->createQueryBuilder('t');

        if ($name) {
            // LIKE permet de rechercher un nom qui contient le mot recherché
            // % permet de rechercher un nom qui commence par le mot recherché
            $filtre->andWhere('t.name LIKE :name')
            ->setParameter('name', '%' . $name . '%');
        }

        if ($code) {
            $filtre->andWhere('t.code LIKE :code')
            ->setParameter('code', '%' . $code . '%');
        }

        return $filtre->getQuery()->getResult();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.code', 'ASC')
            ->getQuery()
            ->getResult();
    }
}