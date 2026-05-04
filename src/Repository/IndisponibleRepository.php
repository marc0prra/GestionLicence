<?php

namespace App\Repository;

use App\Entity\Indisponible;
use App\Entity\Instructor;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Indisponible>
 */
class IndisponibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indisponible::class);
    }

    public function indisponibilites(int $id)
    {
        $qb = $this->createQueryBuilder("i");
        $qb->where("i.instructor = :id")
            ->setParameter("id", $id);
        return $qb->getQuery()->execute();
    }

    public function findIndisponibleByInstructorAndDate(int $id, DateTime $start_date, DateTime $end_date): int
    {
        return (int) $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->where('i.instructor = :id')
            ->andWhere('i.startDate < :end_date')
            ->andWhere('i.endDate > :start_date')

            ->setParameter('id', $id)
            ->setParameter('start_date', $start_date)
            ->setParameter('end_date', $end_date)
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    /**
//     * @return Indisponible[] Returns an array of Indisponible objects
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

    //    public function findOneBySomeField($value): ?Indisponible
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
