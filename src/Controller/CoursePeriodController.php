<?php

namespace App\Controller;

use App\Entity\CoursePeriod;
use App\Entity\SchoolYear;
use App\Form\CoursePeriodType;
use App\Repository\SchoolYearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/course_period')]
final class CoursePeriodController extends AbstractController
{
    // --- 1. AJOUTER UNE SEMAINE (Liée à une année précise) ---
    #[Route('/new/{schoolYearId}', name: 'app_course_period_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SchoolYearRepository $schoolYearRepository,
        int $schoolYearId
    ): Response {
        $schoolYear = $schoolYearRepository->find($schoolYearId);
        // Verifie si il y a une année scolaire correspondante
        if (!$schoolYear) {
            throw $this->createNotFoundException('Année scolaire introuvable');
        }

        $coursePeriod = new CoursePeriod();
        $coursePeriod->setSchoolYearId($schoolYear); 

        $form = $this->createForm(CoursePeriodType::class, $coursePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($coursePeriod);
            $entityManager->flush();

            // Flash message de succès (année bien ajoutée )
            $this->addFlash('success', 'Semaine de cours ajoutée avec succès.');
            
            return $this->redirectToRoute('school_year_edit', ['id' => $schoolYearId]);
        }

        return $this->render('course_period/form.html.twig', [
            'course_period' => $coursePeriod,
            'form' => $form,
            'schoolYear' => $schoolYear,
            'is_edit' => false 
        ]);
    }

    // --- 2. MODIFIER UNE SEMAINE ---
    #[Route('/{id}/edit', name: 'app_course_period_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CoursePeriod $coursePeriod,
        EntityManagerInterface $entityManager
    ): Response {
        $schoolYear = $coursePeriod->getSchoolYearId();

        $form = $this->createForm(CoursePeriodType::class, $coursePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Flash message de succès (année bien modifiée )
            $this->addFlash('success', 'Semaine de cours modifiée avec succès.');

            return $this->redirectToRoute('school_year_edit', ['id' => $schoolYear->getId()]);
        }

        return $this->render('course_period/form.html.twig', [
            'course_period' => $coursePeriod,
            'form' => $form,
            'schoolYear' => $schoolYear,
            'is_edit' => true
        ]);
    }

    // --- 3. SUPPRIMER UNE SEMAINE ---
    #[Route('/{id}', name: 'app_course_period_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CoursePeriod $coursePeriod,
        EntityManagerInterface $entityManager
    ): Response {
        $schoolYearId = $coursePeriod->getSchoolYearId()->getId();
        
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete' . $coursePeriod->getId(), $request->request->get('_token'))) {
            
            $entityManager->remove($coursePeriod);
            $entityManager->flush();

            // Flash message de succès (année bien supprimée )
            $this->addFlash('success', 'Semaine de cours supprimée.');
        }

        return $this->redirectToRoute('school_year_edit', ['id' => $schoolYearId]);
    }
}