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
    public function list(Request $request, InterventionTypeRepository $interventionTypeRepository): Response
    {
        $interventionType = $interventionTypeRepository->findAll();
        $filterForm = $this->createForm(InterventionTypeFilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();
            $interventionType = $interventionTypeRepository->findByFilters($data['name']);
        }

        return $this->render('intervention_type/list.html.twig', [
            'lesInterventions' => $interventionType,
            'form' => $filterForm->createView()
        ]);
    }

    #[Route('/intervention/type/fiche/{id}', name: 'intervention_type_fiche', defaults: ['id' => null], methods: ['GET', 'POST'])]
    public function fiche(Request $request, EntityManagerInterface $entityManager, ?InterventionType $interventionType = null): Response
    {
        $isNew = $interventionType === null;
        if ($isNew) {
            $interventionType = new InterventionType();
        }

        $form = $this->createForm(InterventionTypeType::class, $interventionType);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()) {
                $entityManager->persist($interventionType);
                $entityManager->flush();

                $this->addFlash('success', $isNew ? 'Type d\'intervention créé avec succès.' : 'Type d\'intervention modifié avec succès.');
                return $this->redirectToRoute('intervention_type');
            }
        }

        return $this->render('intervention_type/intervention_type_form.html.twig', [
            'form' => $form->createView(),
            'interventionType' => $interventionType,
        ]);
    }

    #[Route('/intervention/type/{id}/delete', name: 'intervention_type_delete', methods: ['POST'])]
    public function delete(Request $request, InterventionType $interventionType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $interventionType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($interventionType);
            $entityManager->flush();
            $this->addFlash('success', 'Type d\'intervention supprimé avec succès.');
        }

        return $this->redirectToRoute('intervention_type');
    }
}