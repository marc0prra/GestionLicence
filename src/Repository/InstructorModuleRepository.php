<?php

namespace App\Repository;

use App\Entity\InstructorModule;
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

    // Requête pour filtrer les intervenants
    public function findByFilters(?string $name, ?string $firstName, ?string $email): array
    {
        $filtre = $this->createQueryBuilder('t');

        if ($name) {
            $filtre->andWhere('t.nom LIKE :name')
            ->setParameter('name', '%' . $name . '%');
        }

        if ($firstName) {
            $filtre->andWhere('t.prenom LIKE :firstName')
            ->setParameter('firstName', '%' . $firstName . '%');
        }

        if ($email) {
            $filtre->andWhere('t.email LIKE :email')
            ->setParameter('email', '%' . $email . '%');
        }
        return $filtre->getQuery()->getResult();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.nom', 'ASC') 
            ->getQuery()
            ->getResult();
    }
}