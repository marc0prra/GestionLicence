<?php

namespace App\Controller;

use App\Entity\SchoolYear;
use App\Repository\SchoolYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CoursePeriod;
use App\Form\CoursePeriodType;
use Doctrine\ORM\EntityManagerInterface;

final class AnneesScolaireController extends AbstractController
{
    #[Route('/annees/scolaire', name: 'annees_scolaire', methods: ['GET'])]
    public function anneesScolaire(SchoolYearRepository $schoolYearRepository): Response
    {
        $anneesScolaire = $schoolYearRepository->findAll(); 

        return $this->render('annees_scolaire/annees_scolaire.html.twig', [
            'dataAnneesScolaire' => $anneesScolaire
        ]);
    }

    #[Route('/annees/scolaire/new', name: 'app_course_period_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $coursePeriod = new CoursePeriod();
        $form = $this->createForm(CoursePeriodType::class, $coursePeriod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($coursePeriod);
            $entityManager->flush();

            $this->addFlash('success', 'La promotion a bien été enregistrée.');

            return $this->redirectToRoute('app_course_period_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annees_scolaire/new_course_period.html.twig', [
            'course_period' => $coursePeriod,
            'form' => $form,
        ]);
    }
}
