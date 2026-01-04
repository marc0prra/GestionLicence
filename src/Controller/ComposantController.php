<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComponentController extends AbstractController
{

    #[Route('/composants/button-period', name: 'composants_button_period')]
    public function buttonPeriod(): Response
    {
        return $this->render('composants/button_period.html.twig');
    }
}