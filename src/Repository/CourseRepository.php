<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
