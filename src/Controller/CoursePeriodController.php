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
    #[Route(path: '/course_period/new/{schoolYearId}', name: 'app_course_period_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SchoolYearRepository $schoolYearRepository,
        int $schoolYearId,
    ): Response {
        $schoolYear = $schoolYearRepository->find($schoolYearId);

        if (!$schoolYear) {
            throw $this->createNotFoundException('Année scolaire introuvable');
        }

        $coursePeriod = new CoursePeriod();
        $coursePeriod->setSchoolYearId($schoolYear);

        $form = $this->createForm(CoursePeriodType::class, $coursePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->persist($coursePeriod);
                    $entityManager->flush();

                    $this->addFlash('success', 'La semaine de cours a bien été ajoutée');

                    return $this->redirectToRoute('school_year_edit', ['id' => $schoolYearId]);
                } catch (\Exception $exception) {
                    $this->addFlash('error', 'Le formulaire est invalide ou une erreur est survenue');
                }
            } else {
                $this->addFlash('error', 'Le formulaire est invalide');
            }
        }

        return $this->render('course_period/form.html.twig', [
            'course_period' => $coursePeriod,
            'form' => $form,
            'schoolYear' => $schoolYear,
            'is_edit' => false,
        ]);
    }

    #[Route(path: '/course_period/{id}/edit', name: 'app_course_period_edit', methods: ['GET', 'POST'])]
    public function edit(
        CoursePeriod $coursePeriod,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $schoolYear = $coursePeriod->getSchoolYearId();

        $form = $this->createForm(CoursePeriodType::class, $coursePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->flush();

                    $this->addFlash('success', 'La modification a bien été prise en compte');

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
            'is_edit' => true,
        ]);
    }

    #[Route(path: '/course_period/{id}', name: 'app_course_period_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CoursePeriod $coursePeriod,
        EntityManagerInterface $entityManager,
    ): Response {
        $schoolYearId = $coursePeriod->getSchoolYearId()->getId();

        if ($this->isCsrfTokenValid('delete'.$coursePeriod->getId(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($coursePeriod);
                $entityManager->flush();

                $this->addFlash('success', 'La semaine de cours a bien été supprimée');
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Impossible de supprimer cette semaine car des interventions y sont liées');
            }
        }

        return $this->redirectToRoute('school_year_edit', ['id' => $schoolYearId]);
    }
}
