<?php

namespace App\Controller;

use App\Repository\InterventionTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterventionTypeController extends AbstractController
{
    #[Route('/typeintervention', name: 'annees_scolaire', methods: ['GET'])]
    public function InterventionType(InterventionTypeRepository $interventionTypeController): Response
    {
        $interventionType = $interventionTypeController->findAll();

        return $this->render('intervention_type/intervention_type.html.twig', [
            'lesInterventions' => $interventionType
        ]);
    }
}
