<?php

namespace App\Controller;

use App\Entity\SchoolYear;
use App\Repository\SchoolYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnneesScolaireController extends AbstractController
{
    #[Route('/annees/scolaire', name: 'annees_scolaire', methods: ['GET'])]
    public function anneesScolaire(SchoolYearRepository $schoolYearRepository): Response
    {
        $anneesScolaire = $schoolYearRepository->findAll(); 

        return $this->render('annees_scolaire/annees_scolaire.html.twig', [
            'dataAnneesScolaire' => $anneesScolaire
        ]);
    }
}
