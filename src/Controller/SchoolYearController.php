<?php

namespace App\Controller;

use App\Entity\SchoolYear;
use App\Form\SchoolYearType;
use App\Repository\SchoolYearRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CoursePeriod;
use App\Form\CoursePeriodType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

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


    #[Route('/school_year/{id}', name: 'school_year_one', methods: ['GET', 'POST'])]
    public function oneYear(SchoolYear $schoolYear, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SchoolYearType::class, $schoolYear);
        $form->handleRequest($request);

        dd($schoolYear);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('success', 'Modifications enregistrées !');
                    return $this->redirectToRoute('school_year_one', ['id' => $schoolYear->getId()]);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors de la sauvegarde.');
                }
            }
        }

        return $this->render('school_year/form.html.twig', [
            'fiche' => $schoolYear,
            'form' => $form->createView(),
        ]);
    }
}
