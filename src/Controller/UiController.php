<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UiController extends AbstractController
{
    #[Route('/composants/button-period', name: 'composants_button_period', methods: ['GET'])]
    public function buttonPeriod(): Response
    {
        return $this->render('composants/button_period.html.twig');
    }

    #[Route('/composants/multi-select', name: 'composants_multi_select', methods: ['GET'])]
    public function multiSelect(): Response
    {
        $intervenants = [
            ['id' => 1, 'nom' => 'Sonia ARACIL'],
            ['id' => 2, 'nom' => 'Olivier SALESSE'],
            ['id' => 3, 'nom' => 'Jean DUPONT'],
            ['id' => 4, 'nom' => 'Marie CLAIRE'],
        ];

        return $this->render('composants/multi_select.html.twig', [
            'intervenants' => $intervenants,
        ]);
    }

    #[Route('/formulaire-composant', name: 'formulaire_composant')]
    public function index(): Response
    {
        return $this->render('composants/formulaire_composant.html.twig');
    }
}