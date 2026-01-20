<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Filter\TeachingBlockFilterType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TeachingBlock;
use App\Repository\TeachingBlockRepository;
use Doctrine\ORM\EntityManagerInterface;

final class TeachingBlockController extends AbstractController
{
    #[Route(path:'/teaching_block', name: 'teaching_block', methods: ['GET'])]
    public function teachingBlock(Request $request, TeachingBlockRepository $teachingBlockRepository): Response
    {
        $data = new TeachingBlock();
        $form = $this->createForm(TeachingBlockFilterType::class, $data);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $info = $teachingBlockRepository->findByFilters($data->getName(), $data->getCode());
        } 
        else {
            $info = $teachingBlockRepository->findAll();
        }

        return $this->render('teaching_block/teaching_block.html.twig', [
            'info' => $info,
            'form' => $form->createView()
        ]);
    }

    #[Route(path:'/teaching_block_fiche', name: 'teaching_block_fiche', methods: ['GET'])]
    public function teachingBlockFiche(TeachingBlockRepository $teachingBlockRepository, Request $request) : Response 
    {
        return $this->render('teaching_block/teaching_block_fiche.html.twig');
    }
}
