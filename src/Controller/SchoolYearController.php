<?php

namespace App\Controller;

use App\Entity\SchoolYear;
use App\Repository\SchoolYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

final class SchoolYearController extends AbstractController
{
    #[Route('/school_year', name: 'school_year', methods: ['GET'])]
    public function list(SchoolYearRepository $schoolYearRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $schoolYearRepository->findAll(); 

        $schoolYear = $paginator->paginate(
            $donnees, // On lui passe les données
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            10 // Nombre d'éléments maximum pour une page
        );

        return $this->render('school_year/list.html.twig', [
            'dataSchoolYear' => $schoolYear
        ]);
    }
}
