<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Module;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    // public function findAll(): array
    // {
    //     $subQuery = $this->getEntityManager()->createQueryBuilder()
    //         ->select('MIN(c2.start_date)')
    //         ->from('App\Entity\Course', 'c2')
    //         ->getDQL();

    //     return $this->createQueryBuilder('c')
    //         ->select('c.id', 'c.title', 'c.start_date', 'c.end_date', 'c.remotely')
    //         ->addSelect('it.name as Type')
    //         ->addSelect('m.name as Module')
    //         ->addSelect('u.first_name', 'u.last_name')
    //         ->addSelect('(' . $subQuery . ') as oldest_course_date')

    //         ->leftJoin('c.intervention_type_id', 'it')
    //         ->leftJoin('c.module_id', 'm')
    //         ->leftJoin('c.courseInstructors', 'ci')
    //         ->leftJoin('ci.instructor', 'ins')
    //         ->leftJoin('ins.user', 'u')

    //         ->getQuery()
    //         ->getResult();
    // }

//    /**
    public function findByFilters(?Datetime $date_start, ?Datetime $date_end, $module = null): array
    {

        $qb = $this->createQueryBuilder('c')
            ->select('c.id', 'c.title', 'c.start_date', 'c.end_date', 'c.remotely')
            ->addSelect('it.name as Type')
            ->addSelect('m.name as Module')
            ->addSelect('u.first_name', 'u.last_name')

            ->leftJoin('c.intervention_type_id', 'it')
            ->leftJoin('c.module_id', 'm')
            ->leftJoin('c.courseInstructors', 'ci')
            ->leftJoin('ci.instructor', 'ins')
            ->leftJoin('ins.user', 'u');

        if ($date_start) {
            $qb->andWhere('c.start_date >= :ds')
                ->setParameter('ds', $date_start);
        }

        if ($date_end) {
            // On s'assure que la date de fin va jusqu'à 23:59:59 si c'est une date seule
            $qb->andWhere('c.end_date <= :de')
                ->setParameter('de', $date_end);
        }

        if ($module) {
            $qb->andWhere('m.id = :module')
                ->setParameter('module', $module);
        }

        $qb->orderBy('c.start_date', 'ASC');

        return $qb->getQuery()->getResult();
    }

    //    /**
//     * @return Course[] Returns an array of Course objects
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

    //    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
