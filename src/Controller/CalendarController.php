<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CalendarController extends AbstractController
{
    #[Route(path: '/api/calendar', name: 'calendar_api', methods:['GET'])]
    public function data(CourseRepository $calendar): JsonResponse
    {
        $courses = $calendar->findAll();

        $interventions = [];

        foreach($courses as $course) {
            // Construction du nom de l'instructeur
            $instructors = [];
            foreach($course->getCourseInstructors() as $instructor){
                $instructors[] = [
                    'name' => $instructor->getInstructor()->getUser()->getFirstName() . ' ' . $instructor->getInstructor()->getUser()->getLastName(), 
                ];
            }
           
            
            $interventions[] = [
                'id' => $course->getId(), 
                'start' => $course->getStartDate()->format('Y-m-d\TH:i:s'), 
                'end' => $course->getEndDate()->format('Y-m-d\TH:i:s'),
                'title' => $course->getTitle(),
                'remotely' => $course->isRemotely(),
                'module' => $course->getModuleId()->getName(),
                'type' => $course->getInterventionTypeId()->getName(),
                'color' => $course->getInterventionTypeId()->getColor(),
                'instructors' => $instructors,
            ];
        }

        return $this->json($interventions);
    }

    #[Route(path: '/', name: 'calendar', methods:['GET'])]
    public function index():Response
    {
         return $this->render('calendar/index.html.twig');
    }
}
