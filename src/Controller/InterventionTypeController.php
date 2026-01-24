<?php

namespace App\Controller;

use App\Form\Filter\InterventionTypeFilterType;
use App\Repository\InterventionTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterventionTypeController extends AbstractController
{
    #[Route('/intervention_type', name: 'annees_scolaire', methods: ['GET'])]
    public function InterventionType(Request $request, InterventionTypeRepository $interventionTypeRepository): Response
    {
        $interventionType = $interventionTypeRepository->findAll();

        $filterForm = $this->createForm(InterventionTypeFilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            if ($filterForm->isValid()) {
                $data = $filterForm->getData();
                $interventionType = $interventionTypeRepository->findByFilters($data['name']);
            }
        }

        return $this->render('intervention_type/intervention_type.html.twig', [
            'lesInterventions' => $interventionType,
            'form' => $filterForm->createView()
        ]);
    }
}
