<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/interventions', name: 'form_interventions')]
    public function index(EntityManagerInterface $em, Request $request, CoursePeriodRepository $periodRepo): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        // On va récupérer les informations du formulaire pour insérer dans course et dans course_instructor (id de course et id de l'instructeur)
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $period = $periodRepo->findPeriodByDates($course->getStartDate());

                if (!$period) {
                    $this->addFlash('error', 'Aucune période scolaire ne correspond à la date de début choisie.');
                    // On peut choisir d'arrêter l'exécution ici si c'est obligatoire
                    return $this->render('form_interventions.html.twig', ['form' => $form->createView()]);
                }

                // 2. Assigner manuellement la période trouvée
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

        return $this->render('form_interventions.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
