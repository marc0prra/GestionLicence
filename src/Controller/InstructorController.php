<?php

namespace App\Controller;

use App\Entity\Instructor;
use App\Entity\InstructorModule;
use App\Form\Filter\InstructorFilterType;
use App\Form\InstructorType;
use App\Repository\InstructorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InstructorController extends AbstractController
{
    #[Route('/instructors', name: 'app_instructor_index', methods: ['GET'])]
    public function index(Request $request, InstructorRepository $repository): Response
    {
        $form = $this->createForm(InstructorFilterType::class);
        $form->handleRequest($request);

       $filters = [];
        if ($form->isSubmitted()){
            if($form->isValid()){
            $data = $form->getData();
            $filters['lastName'] = $data['lastName'] ?? null;
            $filters['firstName'] = $data['firstName'] ?? null;
            $filters['email'] = $data['email'] ?? null;
        }
        }

        // Gestion de la Pagination
        $limit = 10; // Nombre d'éléments par page 
        $page = $request->query->getInt('page', 1); // Page actuelle (défaut: 1)
        if ($page < 1) $page = 1;

        // Récupération des données
        $instructors = $repository->findByFiltersAndPaginate($filters, $page, $limit);
        $totalInstructors = $repository->countByFilters($filters);

        // Calcul du nombre total de pages
        $maxPages = ceil($totalInstructors / $limit);

        return $this->render('instructor/list.html.twig', [
            'instructors' => $instructors,
            'form' => $form->createView(),
            'currentPage' => $page,
            'maxPages' => $maxPages,
        ]);
    }

    #[Route('/instructors/new', name: 'app_instructor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ): Response
    {
        $instructor = new Instructor();
        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()) {
            // Créer un nouvel utilisateur
            $user = new User();
            $user->setLastName($form->get('lastName')->getData());
            $user->setFirstName($form->get('firstName')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setRole('ROLE_INSTRUCTOR');
            
            // Associer l'utilisateur à l'instructeur
            $instructor->setUser($user);
            
            // Persister l'instructeur (cascade persist pour l'utilisateur)
            $entityManager->persist($instructor);
            
            // Ajouter les modules sélectionnés
            $selectedModules = $form->get('modules')->getData();
            foreach ($selectedModules as $module) {
                $instructorModule = new InstructorModule();
                $instructorModule->setInstructor($instructor);
                $instructorModule->setModule($module);
                $entityManager->persist($instructorModule);
            }

            $entityManager->flush();

            $this->addFlash('success', 'L\'enseignant a été créé avec succès.');
            return $this->redirectToRoute('app_instructor_show', ['id' => $instructor->getId()]);
            }
            }

        return $this->render('instructor/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

#[Route('/instructors/export', name: 'app_instructor_export', methods: ['GET'])]
public function exportInstructors(InstructorRepository $repository): StreamedResponse
{
    $instructors = $repository->findAll(); // Récupère tous les enseignants
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Récapitulatif Enseignants');

    // En-têtes
    $sheet->setCellValue('A1', 'Nom');
    $sheet->setCellValue('B1', 'Prénom');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Modules enseignés');
    $sheet->setCellValue('E1', 'Heures Totales');

    $row = 2;
    foreach ($instructors as $instructor) {
        $user = $instructor->getUser();
        $sheet->setCellValue('A' . $row, $user->getLastName());
        $sheet->setCellValue('B' . $row, $user->getFirstName());
        $sheet->setCellValue('C' . $row, $user->getEmail());

        // Utilise la méthode de votre entité pour lister les modules
        $sheet->setCellValue('D' . $row, $instructor->getModuleNamesString());

        // Utilise la méthode de votre entité pour le total des heures
        $sheet->setCellValue('E' . $row, $instructor->getTotalHours() . ' h');
        
        $row++;
    }

    // Ajustement automatique de la largeur des colonnes
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Création de la réponse, pour éviter l'erreur BinaryFileResponse
    $response = new StreamedResponse(function () use ($spreadsheet) {
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    });

    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // Content-Disposition pour forcer le téléchargement
    $response->headers->set('Content-Disposition', 'attachment;filename="recapitulatif_enseignants.xlsx"');
    // Cache-Control pour éviter les problèmes de cache 
    $response->headers->set('Cache-Control', 'max-age=0');

    return $response;
}

    #[Route('/instructors/{id}', name: 'app_instructor_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Instructor $instructor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InstructorType::class, $instructor);
        
        // Pré-remplir les champs non mappés
        $form->get('lastName')->setData($instructor->getUser()->getLastName());
        $form->get('firstName')->setData($instructor->getUser()->getFirstName());
        $form->get('email')->setData($instructor->getUser()->getEmail());
        
        // Récupérer les modules actuels
        $currentModules = [];
        foreach ($instructor->getInstructorModules() as $InstruModule) {
            $currentModules[] = $InstruModule->getModule();
        }
        $form->get('modules')->setData($currentModules);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()) {
            // Mettre à jour les infos utilisateur
            $instructor->getUser()->setLastName($form->get('lastName')->getData());
            $instructor->getUser()->setFirstName($form->get('firstName')->getData());
            $instructor->getUser()->setEmail($form->get('email')->getData());
            
            $selectedModules = $form->get('modules')->getData();

            // Récupérer les modules actuellement associés
            $currentModuleIds = [];
            foreach ($instructor->getInstructorModules() as $InstruModule) {
                $currentModuleIds[$InstruModule->getModule()->getId()] = $InstruModule;
            }
            
            // Récupérer les modules sélectionnés
            $selectedModuleIds = [];
            foreach ($selectedModules as $module) {
                $selectedModuleIds[$module->getId()] = $module;
            }
            
            // Supprimer les modules qui ne sont plus sélectionnés
            foreach ($currentModuleIds as $moduleId => $InstruModule) {
                if (!isset($selectedModuleIds[$moduleId])) {
                    $instructor->removeInstructorModule($InstruModule);
                    $entityManager->remove($InstruModule);
                }
            }
            
            // Ajouter les nouveaux modules (ceux qui n'existent pas encore)
            foreach ($selectedModuleIds as $moduleId => $module) {
                if (!isset($currentModuleIds[$moduleId])) {
                    $instructorModule = new InstructorModule();
                    $instructorModule->setInstructor($instructor);
                    $instructorModule->setModule($module);
                    $instructor->addInstructorModule($instructorModule);
                    $entityManager->persist($instructorModule);
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Les informations de l\'enseignant ont été mises à jour.');
            return $this->redirectToRoute('app_instructor_show', ['id' => $instructor->getId()]);
            }
            }

        return $this->render('instructor/show.html.twig', [
            'instructor' => $instructor,
            'form' => $form->createView(),
        ]);
    }
    
}