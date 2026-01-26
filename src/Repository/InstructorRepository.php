<?php

namespace App\Repository;

use App\Entity\Instructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Instructor>
 */
class InstructorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instructor::class);
    }

    /**
     * Récupère les instructeurs pour une page donnée
     */
    public function findByFiltersAndPaginate(array $filters, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('i')
            ->join('i.user', 'u')
            ->addSelect('u')
            // CORRECTION ICI : u.lastName -> u.last_name
            ->orderBy('u.last_name', 'ASC'); 

        // Application des filtres
        if (!empty($filters['lastName'])) {
            // CORRECTION ICI : u.lastName -> u.last_name
            $qb->andWhere('u.last_name LIKE :lname')
               ->setParameter('lname', '%' . $filters['lastName'] . '%');
        }
        if (!empty($filters['firstName'])) {
            // CORRECTION ICI : u.firstName -> u.first_name
            $qb->andWhere('u.first_name LIKE :fname')
               ->setParameter('fname', '%' . $filters['firstName'] . '%');
        }
        if (!empty($filters['email'])) {
            $qb->andWhere('u.email LIKE :email')
               ->setParameter('email', '%' . $filters['email'] . '%');
        }

        // Pagination Manuelle
        $qb->setFirstResult(($page - 1) * $limit)
           ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * Compte le nombre total de résultats (pour la pagination)
     */
    public function countByFilters(array $filters): int
    {
        $qb = $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->join('i.user', 'u');

        if (!empty($filters['lastName'])) {
            // CORRECTION ICI
            $qb->andWhere('u.last_name LIKE :lname')
               ->setParameter('lname', '%' . $filters['lastName'] . '%');
        }
        if (!empty($filters['firstName'])) {
            // CORRECTION ICI
            $qb->andWhere('u.first_name LIKE :fname')
               ->setParameter('fname', '%' . $filters['firstName'] . '%');
        }
        if (!empty($filters['email'])) {
            $qb->andWhere('u.email LIKE :email')
               ->setParameter('email', '%' . $filters['email'] . '%');
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}