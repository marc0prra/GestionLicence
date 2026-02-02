<?php

namespace App\Controller;

use App\Entity\SchoolYear;
use App\Form\SchoolYearType;
use App\Repository\SchoolYearRepository;
use App\Repository\CoursePeriodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\CoursePeriod;
use App\Form\CoursePeriodType;

final class SchoolYearController extends AbstractController
{
    #[Route('/school_year', name: 'school_year', methods: ['GET'])]
    public function list(SchoolYearRepository $schoolYearRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $schoolYearRepository->findAll();

        $schoolYear = $paginator->paginate(
            $donnees, // On lui passe les données
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            10 // Nombre d'éléments maximum pour une page
        );

        return $this->render('school_year/list.html.twig', [
            'dataSchoolYear' => $schoolYear
        ]);
    }


    #[Route('/school_year/{id}/edit', name: 'school_year_edit', methods: ['GET', 'POST'])]
    public function oneYear(SchoolYear $schoolYear, Request $request, EntityManagerInterface $em, CoursePeriodRepository $coursePeriodrepository): Response
    {
        // 1 - Formulaire de modification d'une année scolaire
        $currentSaison = '';
        if ($schoolYear->getStartDate() && $schoolYear->getEndDate()) {
            $startYear = $schoolYear->getStartDate()->format('Y');
            $endYear = $schoolYear->getEndDate()->format('Y');
            $currentSaison = $startYear . '/' . $endYear;
        }

        $form = $this->createForm(SchoolYearType::class, $schoolYear);
        $form->get('saison')->setData($currentSaison);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $saison = $form->get('saison')->getData();
                    if ($saison && preg_match('/^(\d{4})\/(\d{4})$/', $saison, $matches)) {
                        $startYear = (int) $matches[1];
                        $endYear = (int) $matches[2];

                        $schoolYear->setStartDate(new \DateTime("$startYear-09-01"));
                        $schoolYear->setEndDate(new \DateTime("$endYear-08-31"));
                    }

                    $em->flush();
                    $this->addFlash('success', 'Modifications enregistrées !');
                    return $this->redirectToRoute('school_year_edit', [
                        'id' => $schoolYear->getId()
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors de la sauvegarde.');
                }
            }
        }

        // 2 - Tableaux des semaines
        $coursePeriods = $coursePeriodrepository->findBySchoolYear($schoolYear->getId());

        return $this->render('school_year/form.html.twig', [
            'form' => $form,
            'schoolYear' => $schoolYear,
            'coursePeriods' => $coursePeriods,
        ]);
    }

    #[Route('/school_year/add', name: 'school_year_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $year = new SchoolYear();
        $form = $this->createForm(SchoolYearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $saison = $form->get('saison')->getData();
                    if ($saison && preg_match('/^(\d{4})\/(\d{4})$/', $saison, $matches)) {
                        $startYear = (int) $matches[1];
                        $endYear = (int) $matches[2];

                        $year->setStartDate(new \DateTime("$startYear-09-01"));
                        $year->setEndDate(new \DateTime("$endYear-08-31"));
                    }

                    $em->persist($year);
                    $em->flush();
                    $this->addFlash('success', 'Année scolaire ajoutée !');
                    return $this->redirectToRoute('school_year');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors de lajout.');
                }
            }
        }

        return $this->render('school_year/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/school_year/{id}/delete', name: 'school_year_delete', methods: ['POST'])]
    public function delete(SchoolYear $schoolYear, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $schoolYear->getId(), $request->request->get('_token'))) {
            try {
                $em->remove($schoolYear);
                $em->flush();
                $this->addFlash('success', 'Année scolaire supprimée avec succès !');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Impossible de supprimer cette année scolaire car elle est liée à des cours.');
            }
        }

        return $this->redirectToRoute('school_year');
    }
}
