<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalendarController extends AbstractController
{
    #[Route(path: '/calendar', name: 'calendar', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('calendar/index.html.twig');
    }
}
