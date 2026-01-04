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

    #[Route('/design/test', name: 'app_design_test')]
    public function index(): Response
    {
        $projets = [
            ['nom' => 'Refonte Site Web', 'client' => 'Acme Corp', 'statut' => 'Actif'],
            ['nom' => 'App Mobile', 'client' => 'StartUp Inc', 'statut' => 'En pause'],
            ['nom' => 'Audit SEO', 'client' => 'Google', 'statut' => 'Terminé'],
        ];

        return $this->render('testDesign/index.html.twig', [
            'projets' => $projets,
        ]);
    }
}