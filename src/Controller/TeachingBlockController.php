<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Filter\TeachingBlockFilterType;
use Symfony\Component\HttpFoundation\Request;

final class TeachingBlockController extends AbstractController
{
    #[Route(path:'/teaching/block', name: 'teaching_block', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, Request $request, TeachingBlockRepository $teachingBlockRepository): Response
    {
        $form = $this->createForm(TeachingBlockFilterType::class, $teachingBlockRepository);
        $form->handleRequest($request);

        return $this->render('teaching_block/teaching_block.html.twig', [
            'controller_name' => 'TeachingBlockController',
        ]);
    }
}
