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
use App\Repository\CourseRepository;
use App\Repository\CoursePeriodRepository;

class InterventionController extends AbstractController
{
    // InterventionController.php

    #[Route('/interventions', name: 'interventions', methods: ['GET', 'POST'])]
    public function list(CourseRepository $courseRepo, Request $request): Response
    {
        $interventions = $courseRepo->findAll();
        $filterForm = $this->createForm(CourseFilterType::class);
        $filterForm->handleRequest($request);

        // ... logique de filtrage si nécessaire ...

        return $this->render('intervention/list.html.twig', [
            'interventions' => $interventions,
            'form' => $filterForm->createView(),
        ]);
    }

    #[Route('/interventions/add', name: 'intervention_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, CoursePeriodRepository $periodRepo): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $period = $periodRepo->findPeriodByDates($course->getStartDate());

            if (!$period) {
                $this->addFlash('error', 'Aucune période scolaire correspondante.');
            } else {
                $course->setCoursePeriodId($period);
                $em->persist($course);

                // Gestion des intervenants (champ non-mappé)
                $instructors = $form->get('courseInstructors')->getData();
                foreach ($instructors as $instructor) {
                    $ci = new CourseInstructor();
                    $ci->setCourse($course)->setInstructor($instructor);
                    $em->persist($ci);
                }

                $em->flush();
                $this->addFlash('success', 'Intervention créée !');
                return $this->redirectToRoute('interventions');
            }
        }

        return $this->render('intervention/form.html.twig', [
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/interventions/{id}/edit', name: 'intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Course $course, Request $request, EntityManagerInterface $em): Response
    {
        $currentInstructors = [];
        foreach ($course->getCourseInstructors() as $ci) {
            $currentInstructors[] = $ci->getInstructor();
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->get('courseInstructors')->setData($currentInstructors);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($course->getCourseInstructors() as $oldCi) {
                $em->remove($oldCi);
            }

            $newInstructors = $form->get('courseInstructors')->getData();
            foreach ($newInstructors as $instructor) {
                $ci = new CourseInstructor();
                $ci->setCourse($course)->setInstructor($instructor);
                $em->persist($ci);
            }

            $em->flush();
            $this->addFlash('success', 'Fiche mise à jour.');
            return $this->redirectToRoute('interventions');
        }

        return $this->render('intervention/form.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }
}
