<?php

namespace App\Controller;

use App\Form\Filter\InterventionTypeFilterType;
use App\Repository\InterventionTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\InterventionTypeType;
use App\Entity\InterventionType;
use Doctrine\ORM\EntityManagerInterface;

final class InterventionTypeController extends AbstractController
{
    #[Route('/intervention_type', name: 'intervention_type', methods: ['GET'])]
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


    #[Route('/intervention/type/fiche', name: 'intervention_type_fiche', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $interventionType = new InterventionType();

        $form = $this->createForm(InterventionTypeType::class, $interventionType);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager->persist($interventionType);
                $entityManager->flush();

                $this->addFlash('success', 'Type d\'intervention créé avec succès.');

                return $this->redirectToRoute('intervention_type_fiche');
                // Redirection vers la liste des types d'intervention après création
                // return $this->redirectToRoute('intervention_type');
            } else {
                $this->addFlash('error', 'Le formulaire est invalide.');
            }
        }

        return $this->render('intervention_type/intervention_type_form.html.twig', [
            'form' => $form->createView(),
            'intervention_type' => $interventionType,
        ]);
    }
}
