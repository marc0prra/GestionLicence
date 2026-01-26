<?php

namespace App\Repository;

use App\Entity\Instructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InstructorModule>
 */
class InstructorModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstructorModule::class);
    }

    
    // Récupère les instructeurs pour une page donnée
    
    public function findByFiltersAndPaginate(array $filters, int $page, int $limit): array
    {
        $query = $this->createQueryBuilder('i')
            ->join('i.user', 'u')
            ->addSelect('u') // Optimisation pour éviter 10 requêtes supplémentaires
            ->orderBy('u.LastName', 'ASC');

        // Application des filtres
        if (!empty($filters['LastName'])) {
            $query->andWhere('u.LastName LIKE :lname')
               ->setParameter('lname', '%' . $filters['LastName'] . '%');
        }
        if (!empty($filters['firstName'])) {
            $query->andWhere('u.firstName LIKE :fname')
               ->setParameter('fname', '%' . $filters['firstName'] . '%');
        }
        if (!empty($filters['email'])) {
            $query->andWhere('u.email LIKE :email')
               ->setParameter('email', '%' . $filters['email'] . '%');
        }

        // Pagination 
        $query->setFirstResult(($page - 1) * $limit)
           ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }



    // Compte le nombre total de résultats (pour calculer le nombre de pages)

    public function countByFilters(array $filters): int
    {
        $query = $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->join('i.user', 'u');

        if (!empty($filters['LastName'])) {
            $query->andWhere('u.LastName LIKE :lname')
               ->setParameter('lname', '%' . $filters['LastName'] . '%');
        }
        if (!empty($filters['firstName'])) {
            $query->andWhere('u.firstName LIKE :fname')
               ->setParameter('fname', '%' . $filters['firstName'] . '%');
        }
        if (!empty($filters['email'])) {
            $query->andWhere('u.email LIKE :email')
               ->setParameter('email', '%' . $filters['email'] . '%');
        }

        return $query->getQuery()->getSingleScalarResult();
    }
}