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

class InterventionController extends AbstractController
{
    #[Route('/interventions', name: 'form_interventions')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    // Étape 1 : Insérer d'abord le Course dans la base de données
                    $em->persist($course);
                    $em->flush();

                    // Étape 2 : Récupérer les instructeurs sélectionnés depuis le formulaire
                    $instructors = $form->get('courseInstructors')->getData();

                    // Étape 3 : Créer les entités CourseInstructor pour chaque instructeur
                    if ($instructors) {
                        foreach ($instructors as $instructor) {
                            $courseInstructor = new CourseInstructor();
                            $courseInstructor->setCourse($course);
                            $courseInstructor->setInstructor($instructor);
                            $em->persist($courseInstructor);
                        }

                        // Étape 4 : Flush pour insérer les CourseInstructor
                        $em->flush();
                    }

                    $this->addFlash('success', 'Intervention ajoutée.');
                    return $this->redirectToRoute('form_interventions');
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
