<?php

namespace App\Controller;

use App\Form\Filter\InstructorModuleType;
use App\Repository\InstructorModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\InstructorModule;

final class InstructorModuleController extends AbstractController
{
    #[Route(path: '/instructor_module', name: 'instructor_module', methods: ['GET'])]
    public function list(Request $request, InstructorModuleRepository $instructorModuleRepository): Response
    {
        // Récupération de tous les intervenants 
        $instructorModule = $instructorModuleRepository->findAll();
        $filterForm = $this->createForm(InstructorModuleType::class);        
        $filterForm->handleRequest($request);

        // Gestion des filtres
        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();
            $instructorModule = $instructorModuleRepository->findByFilters(
                $data['name'],
                $data['firstName'],
                $data['email']
            );
        }

        return $this->render('instructor_module/list.html.twig', [
            'lesInstructors' => $instructorModule,
            'form' => $filterForm->createView()
        ]);
    }
}