<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Filter\TeachingBlockFilterType;
use App\Form\TeachingBlockType;
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

    #[Route(path:'/teaching_block/{id}/edit', name: 'teaching_block_edit', methods: ['GET', 'POST'])]
    public function teachingBlockEdit(TeachingBlock $teachingBlock, Request $request, EntityManagerInterface $entityManager) : Response 
    {
        $form = $this->createForm(TeachingBlockType::class, $teachingBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->flush();

                    $this->addFlash('success', 'La modification a bien été prise en compte');

                    return $this->redirectToRoute('teaching_block_edit', [
                        'id' => $teachingBlock->getId(),
                    ]);
                } catch (\Exception $exception) {
                    $this->addFlash('error', 'Le formulaire est invalide');
                }
            }
        }

        return $this->render('teaching_block/teaching_block_edit.html.twig', [
            'form' => $form,
            'teachingBlock' => $teachingBlock,
        ]);
    }
}
