<?php

namespace App\Repository;

use App\Entity\SchoolYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SchoolYear>
 */
class SchoolYearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SchoolYear::class);
    }

    public function findAll() : array 
    {
        return $this->createQueryBuilder('s')
        ->select('s.id', 's.name', 's.start_date', 's.end_date')
        ->orderBy('s.name', 'DESC')
        ->getQuery()
        ->getResult();
    }
}
