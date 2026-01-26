<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Form\Filter\CourseFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Course;
use App\Entity\CourseInstructor;
use App\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CoursePeriodRepository;

class InterventionController extends AbstractController
{
    #[Route('/intervention', name: 'intervention', methods: ['GET'])]
    public function Intervention(Request $request, CoursePeriodRepository $periodRepo): Response
    {
        $interventionType = $periodRepo->findAll();

        $filterForm = $this->createForm(CourseFilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            if ($filterForm->isValid()) {
                $data = $filterForm->getData();
                $interventionType = $periodRepo->findByFilters($data['name']);
            }
        }

        return $this->render('intervention_type/intervention_type.html.twig', [
            'lesInterventions' => $interventionType,
            'form' => $filterForm->createView()
        ]);
    }




    #[Route('/interventions', name: 'form_interventions')]
    public function InterventionForm(EntityManagerInterface $em, Request $request, CoursePeriodRepository $periodRepo): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $period = $periodRepo->findPeriodByDates($course->getStartDate());

                if (!$period) {
                    $this->addFlash('error', 'Aucune période scolaire ne correspond à la date de début choisie.');

                    return $this->render('form_interventions.html.twig', ['form' => $form->createView()]);
                }

                $course->setCoursePeriodId($period);
                try {
                    $em->persist($course);
                    $instructors = $form->get('courseInstructors')->getData();

                    foreach ($instructors as $instructor) {
                        $courseInstructor = new CourseInstructor();
                        $courseInstructor->setCourse($course);
                        $courseInstructor->setInstructor($instructor);
                        $em->persist($courseInstructor);
                    }
                    $em->flush();
                    $this->addFlash('success', 'Intervention ajoutée.');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'ajout de l\'intervention : ' . $e->getMessage());
                }
            } else {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'ajout de l\'intervention.');
            }
        }

        return $this->render('intervention/form_interventions.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
