<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TeachingBlockController extends AbstractController
{
    #[Route(path:'/teaching/block', name: 'teaching_block', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('teaching_block/teaching_block.html.twig', [
            'controller_name' => 'TeachingBlockController',
        ]);
    }
}
