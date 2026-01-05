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

    #[Route('/composants/sidebar', name: 'composants_sidebar', methods: ['GET'])]
    public function sidebar(): Response
    {
        return $this->render('composants/sidebar.html.twig');
    }

    #[Route('/design/test', name: 'app_design_test', methods: ['GET'])]
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

    #[Route('/formulaire-composant', name: 'formulaire_composant', methods: ['GET'])]
    public function formulaireComposant(): Response
    {
        return $this->render('composants/formulaire_composant.html.twig');
    }

    #[Route('/legende-calendar', name: 'legende_calendar', methods: ['GET'])]
    public function legendeCalendar(): Response
    {
        return $this->render('composants/legende_calendar.html.twig');
    }

    #[Route('/test-composants', name: 'app_test_composants')]
    public function test(): Response
    {
        return $this->render('components_test.html.twig');
    }
}