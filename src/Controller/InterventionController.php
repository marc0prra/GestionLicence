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

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $data = $filterForm->getData();
            $interventions = $courseRepo->findByFilters($data['start_date'], $data['end_date'], $data['module_id']);
        }

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
            'form' => $form,
            'course' => $course
        ]);
    }

    #[Route('/interventions/{id}/edit', name: 'intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Course $course, Request $request, EntityManagerInterface $em): Response
    {
        $currentInstructors = $course->getCourseInstructors()->map(fn($ci) => $ci->getInstructor());

        $form = $this->createForm(CourseType::class, $course);
        $form->get('courseInstructors')->setData($currentInstructors);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newInstructors = $form->get('courseInstructors')->getData();

            foreach ($course->getCourseInstructors() as $ci) {
                if (!$newInstructors->contains($ci->getInstructor())) {
                    $em->remove($ci);
                }
            }
            $existingInstructors = $course->getCourseInstructors()->map(fn($ci) => $ci->getInstructor())->toArray();

            foreach ($newInstructors as $instructor) {
                if (!in_array($instructor, $existingInstructors, true)) {
                    $ci = new CourseInstructor();
                    $ci->setCourse($course)->setInstructor($instructor);
                    $em->persist($ci);
                }
            }

            $em->flush();
            $this->addFlash('success', 'Fiche mise à jour.');
            return $this->redirectToRoute('interventions');
        }

        return $this->render('intervention/form.html.twig', [
            'course' => $course,
            'form' => $form,
            'is_edit' => true
        ]);
    }

    #[Route(path: '/interventions/{id}', name: 'interventions_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Course $course,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($course);
                $entityManager->flush();

                $this->addFlash('success', 'Le cours a bien été supprimé.');
            } catch (\Exception $exception) {

                $this->addFlash('error', 'Impossible de supprimer ce cours.');
            }
        }

        return $this->redirectToRoute('interventions');
    }
}
