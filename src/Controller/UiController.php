<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route; 

class UiController extends AbstractController
{
    #[Route('/composants/button-period', name: 'composants_button_period', methods: ['GET'])]
    public function buttonPeriod(): Response
    {
        return $this->render('composants/button_period.html.twig');
    }
}