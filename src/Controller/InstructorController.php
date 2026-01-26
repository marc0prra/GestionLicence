<?php

namespace App\Controller;

use App\Form\Filter\InstructorFilterType;
use App\Repository\InstructorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InstructorController extends AbstractController
{
    #[Route('/instructors', name: 'app_instructor_index', methods: ['GET'])]
    public function index(Request $request, InstructorRepository $repository): Response
    {
        // 1. Gestion du Formulaire de Filtre
        $form = $this->createForm(InstructorFilterType::class);
        $form->handleRequest($request);

       $filters = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $filters['lastName'] = $data['lastName'] ?? null;
            $filters['firstName'] = $data['firstName'] ?? null;
            $filters['email'] = $data['email'] ?? null;
        }

        // 2. Gestion de la Pagination
        $limit = 10; // Nombre d'éléments par page 
        $page = $request->query->getInt('page', 1); // Page actuelle (défaut: 1)
        if ($page < 1) $page = 1;

        // 3. Récupération des données
        $instructors = $repository->findByFiltersAndPaginate($filters, $page, $limit);
        $totalInstructors = $repository->countByFilters($filters);

        // 4. Calcul du nombre total de pages
        $maxPages = ceil($totalInstructors / $limit);

        return $this->render('instructor/list.html.twig', [
            'instructors' => $instructors,
            'form' => $form->createView(),
            'currentPage' => $page,
            'maxPages' => $maxPages,
        ]);
    }
}