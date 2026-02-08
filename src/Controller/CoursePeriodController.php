<?php

namespace App\Controller;

use App\Entity\CoursePeriod;
use App\Form\CoursePeriodType;
use App\Repository\SchoolYearRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CoursePeriodController extends AbstractController
{
    // AJOUTER UNE SEMAINE
    #[Route(path: '/course_period/new/{schoolYearId}', name: 'app_course_period_new', methods: ['GET', 'POST'])]
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

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                try {
                    $entityManager->persist($coursePeriod);
                    $entityManager->flush();

                    // Flash message 
                    $this->addFlash('success', 'Semaine de cours ajoutée avec succès.');

                    return $this->redirectToRoute('school_year_edit', ['id' => $schoolYearId]);
                } catch (\Exception $exception) {
                    $this->addFlash('error', 'Le formulaire est invalide ou une erreur est survenue');
                }
            }
        }

        return $this->render('course_period/form.html.twig', [
            'course_period' => $coursePeriod,
            'form' => $form,
            'schoolYear' => $schoolYear,
            'is_edit' => false
        ]);
    }

    // MODIFIER UNE SEMAINE
    #[Route(path: '/course_period/{id}/edit', name: 'app_course_period_edit', methods: ['GET', 'POST'])]
    public function edit(
        CoursePeriod $coursePeriod,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $schoolYear = $coursePeriod->getSchoolYearId();

        $form = $this->createForm(CoursePeriodType::class, $coursePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->flush();

                    // Flash message 
                    $this->addFlash('success', 'Semaine de cours modifiée avec succès.');

                    return $this->redirectToRoute('school_year_edit', ['id' => $schoolYear->getId()]);
                } catch (\Exception $exception) {
                    $this->addFlash('error', 'Le formulaire est invalide');
                }
            }
        }

        return $this->render('course_period/form.html.twig', [
            'course_period' => $coursePeriod,
            'form' => $form,
            'schoolYear' => $schoolYear,
            'is_edit' => true
        ]);
    }

    // SUPPRIMER UNE SEMAINE 
    #[Route(path: '/course_period/{id}', name: 'app_course_period_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CoursePeriod $coursePeriod,
        EntityManagerInterface $entityManager
    ): Response {
        $schoolYearId = $coursePeriod->getSchoolYearId()->getId();

        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete' . $coursePeriod->getId(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($coursePeriod);
                $entityManager->flush();

                // Flash message 
                $this->addFlash('success', 'Semaine de cours supprimée.');
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Une erreur est survenue lors de la suppression');
            }
        }

        return $this->redirectToRoute('school_year_edit', ['id' => $schoolYearId]);
    }
}