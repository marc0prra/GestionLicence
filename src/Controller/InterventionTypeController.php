<?php

namespace App\Controller;

use App\Form\InterventionTypeType;
use App\Entity\InterventionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


final class InterventionTypeController extends AbstractController
{
    // #[Route('/intervention/type', name: 'intervention_type')]
    // public function index(): Response
    // {
    //     return $this->render('intervention_type/intervention_type_form.html.twig', [
    //         'controller_name' => 'InterventionTypeController',
    //     ]);
    // }

    #[Route('/intervention/type/fiche', name: 'intervention_type_fiche', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $interventionType = new InterventionType();

        $form = $this->createForm(InterventionTypeType::class, $interventionType);

        $form->handleRequest($request);

        if ($form->isSubmitted()) 
        {
            if ($form->isValid()) 
            {
                $entityManager->persist($interventionType);
                $entityManager->flush();

                $this->addFlash('success', 'Type d\'intervention créé avec succès.');
                
                return $this->redirectToRoute('intervention_type_fiche');
                // Redirection vers la liste des types d'intervention après création
                // return $this->redirectToRoute('intervention_type');
            } 
            else 
            {
                $this->addFlash('error', 'Le formulaire est invalide.');
            }
        }

        return $this->render('intervention_type/intervention_type_form.html.twig', [
            'form' => $form->createView(),
            'intervention_type' => $interventionType,
        ]);
    }
}