<?php

namespace App\Controller;

use App\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
// Importations pour l'export Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Request;

final class CalendarController extends AbstractController
{
    #[Route(path: '/api/calendar', name: 'calendar_api', methods:['GET'])]
    public function data(Request $request, CourseRepository $courseRepository): JsonResponse
    {
        // Récupération des interventions de la période active actuelle
        $courses = $courseRepository->getCoursBetween(null, null);

        $interventions = [];

        foreach($courses as $course) {
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

    #[Route(path: '/calendar', name: 'calendar', methods:['GET'])]
    public function index():Response
    {
         return $this->render('calendar/index.html.twig');
    }

    // Export du calendrier
   #[Route('/calendar/export', name: 'calendar_export', methods: ['GET'])]
    public function exportCalendar(CourseRepository $repository): StreamedResponse
    {
        $courses = $repository->findAll(); 
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Liste des interventions');

        // En-têtes
        $sheet->setCellValue('A1', 'Titre');
        $sheet->setCellValue('B1', 'Type');
        $sheet->setCellValue('C1', 'Date de début');
        $sheet->setCellValue('D1', 'Date de fin');
        $sheet->setCellValue('E1', 'A distance');
        $sheet->setCellValue('F1', 'Module');
        $sheet->setCellValue('G1', 'Enseignant');

        $row = 2;
        foreach ($courses as $course) {
            $sheet->setCellValue('A' . $row, $course->getTitle());
            $sheet->setCellValue('B' . $row, $course->getInterventionTypeId()->getName());
            $sheet->setCellValue('C' . $row, $course->getStartDate()->format('Y-m-d\TH:i:s'));
            $sheet->setCellValue('D' . $row, $course->getEndDate()->format('Y-m-d\TH:i:s'));
            $sheet->setCellValue('E' . $row, $course->isRemotely());
            $sheet->setCellValue('F' . $row, $course->getModuleId()->getName());
            $instructorNames = [];
            foreach ($course->getCourseInstructors() as $courseInstructor) {
                $instructorNames[] = $courseInstructor->getInstructor()->getUser()->getLastName() . ' ' . $courseInstructor->getInstructor()->getUser()->getFirstName();
            }
            $sheet->setCellValue('G' . $row, implode(', ', $instructorNames));

            $row++;
        }

        // Ajustement automatique de la largeur des colonnes
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Création de la réponse, pour éviter l'erreur BinaryFileResponse
        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // Content-Disposition pour forcer le téléchargement
        $response->headers->set('Content-Disposition', 'attachment;filename="liste_interventions.xlsx"');
        // Cache-Control pour éviter les problèmes de cache 
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    #[Route(path: 'calendar/planning_period_export', name: 'calendar_planning_period_export', methods: ['GET'])] 
    public function exportPlanningPeriod(CourseRepository $repository): StreamedResponse
    {
        $courses = $repository->findAll();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Planning des interventions de la semaine');
    }
}
