<?php

namespace App\Controller;

use App\Entity\Indisponible;
use App\Entity\CourseInstructor;
use App\Form\CourseType;
use App\Form\Filter\CourseFilterType;
use App\Repository\CoursePeriodRepository;
use App\Repository\CourseRepository;
use App\Repository\IndisponibleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndisponibleController extends AbstractController
{

    #[Route('/indisponibles', name: 'indisponibles', methods: ['GET', 'POST'])]
    public function list(IndisponibleRepository $indisRepo, Request $request): Response
    {
        $indisponibles = $indisRepo->findAll();

        return $this->render('indisponible/list.html.twig', [
            'indisponibles' => $indisponibles
        ]);
    }

}