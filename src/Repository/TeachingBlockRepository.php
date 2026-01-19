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

    public function findByFilters(?string $name, ?string $code): array
    {
        $filtre = $this->createQueryBuilder('t')
            ->select('t.id', 't.name', 't.code', 't.description', 't.hours_count');

        if ($name) {
            // LIKE permet de rechercher un nom qui contient le mot recherché
            $filtre->andWhere('t.name LIKE :name')
            ->setParameter('name', $name );
        }

        if ($code) {
            $filtre->andWhere('t.code LIKE :code')
            ->setParameter('code', $code );
        }

        return $filtre->getQuery()->getResult();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id', 't.name', 't.code', 't.description', 't.hours_count')
            ->getQuery()
            ->getResult();
    }
}
