<?php

namespace App\Repository;

use App\Entity\CoursePeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoursePeriod>
 */
class CoursePeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursePeriod::class);
    }

    public function findBySchoolYear($schoolYearId)
    {
        return $this->createQueryBuilder('cp')
            ->where('cp.school_year_id = :schoolYearId')
            ->setParameter('schoolYearId', $schoolYearId)
            ->getQuery()
            ->getResult();
    }

    public function findPeriodByDates(\DateTimeInterface $startDate): ?CoursePeriod
    {
        return $this->createQueryBuilder('cp')
            ->where(':date BETWEEN cp.start_date AND cp.end_date')
            ->setParameter('date', $startDate)
            ->setMaxResults(1) // On en prend une seule au cas où
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPeriodByCourseDates(\DateTime $startDate, \DateTime $endDate): ?CoursePeriod
    {
        return $this->createQueryBuilder('p')
            ->where('p.start_date <= :start')
            ->andWhere('p.end_date >= :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return CoursePeriod[] Returns an array of CoursePeriod objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CoursePeriod
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
