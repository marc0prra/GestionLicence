<?php

namespace App\Repository;

use App\Entity\InterventionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InterventionType>
 */
class InterventionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterventionType::class);
    }

    public function findByFilters(?string $name): array
    {
        $filtre = $this->createQueryBuilder('it')
            ->select('it.id', 'it.name', 'it.description', 'it.color');

        if ($name) {
            $filtre->andWhere('it.name LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }

        return $filtre->getQuery()->getResult();
    }

    //    /**
    //     * @return InterventionType[] Returns an array of InterventionType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?InterventionType
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
