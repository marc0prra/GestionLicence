<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;

class InterventionController extends AbstractController
{
    #[Route('/interventions', name: 'form_interventions')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(CourseType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $em->flush();
                    $this->addFlash('success', 'Intervention ajoutée.');
                    return $this->redirectToRoute('form_interventions');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'ajout de l\'intervention.');
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
