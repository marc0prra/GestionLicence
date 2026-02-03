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
    #[Route('/interventions', name: 'interventions', methods: ['GET', 'POST'])]
    public function list(
        EntityManagerInterface $em,
        Request $request,
        CourseRepository $courseRepo,
        CoursePeriodRepository $periodRepo
    ): Response {
        $interventions = $courseRepo->findAll();
        $filterForm = $this->createForm(CourseFilterType::class);
        $filterForm->handleRequest($request);

        $newCourse = new Course();
        $addForm = $this->createForm(CourseType::class, $newCourse);
        $addForm->handleRequest($request);
        if ($addForm->isSubmitted()) {

            if ($addForm->isValid()) {
                $period = $periodRepo->findPeriodByDates($newCourse->getStartDate());

                if (!$period) {
                    $this->addFlash('error', 'Aucune période scolaire ne correspond à la date choisie.');
                } else {
                    $newCourse->setCoursePeriodId($period);
                    try {
                        $em->persist($newCourse);
                        $instructors = $addForm->get('courseInstructors')->getData();

                        foreach ($instructors as $instructor) {
                            $courseInstructor = new CourseInstructor();
                            $courseInstructor->setCourse($newCourse);
                            $courseInstructor->setInstructor($instructor);
                            $em->persist($courseInstructor);
                        }
                        $em->flush();
                        $this->addFlash('success', 'Intervention ajoutée.');

                        // On redirige vers la même page pour vider le formulaire et voir le nouvel élément
                        return $this->redirectToRoute('interventions');
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'Erreur : ' . $e->getMessage());
                    }
                }
            }
        }

        return $this->render('intervention/list.html.twig', [
            'interventions' => $interventions,
            'form' => $filterForm->createView(),
            'formAdd' => $addForm->createView(),
        ]);
    }

    #[Route('/intervention', name: 'form_interventions')]
    public function form(EntityManagerInterface $em, Request $request, CourseRepository $periodRepo): Response
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

        return $this->render('intervention/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
