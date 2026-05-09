<?php

namespace App\Repository;

use App\Entity\Unaivibility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unaivibility>
 */
class UnaivibilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unaivibility::class);
    }

    public function findIndisponibilite(int $id, \DateTime $start_date, \DateTime $end_date) {
        return $this->createQueryBuilder('u')
            ->select('count.u')
            ->where('u.instructor = :id')
            ->andWhere('u.startDate < :end')
            ->andWhere('u.endDate > :start')

            ->setParameter('id', $id)
            ->setParameter('start_date', $start_date)
            ->setParameter('end_date', $end_date)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

//    /**
//     * @return Unaivibility[] Returns an array of Unaivibility objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Unaivibility
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
