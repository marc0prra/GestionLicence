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
    public function list(Request $request, TeachingBlockRepository $teachingBlockRepository): Response
    {
        // Initialisation de la classe 
        $data = new TeachingBlock();
        // Création du formulaire
        $form = $this->createForm(TeachingBlockFilterType::class, $data);
        // Gestion de la requête
        $form->handleRequest($request);

        // Gestion des filtres
        if($form->isSubmitted()) {
            // Si le formulaire est soumis, on récupère les filtres
            $info = $teachingBlockRepository->findByFilters($data->getName(), $data->getCode());
        } 
        else {
            // Sinon, on récupère tous les blocs
            $info = $teachingBlockRepository->findAll();
        }

        // Rendu de la vue
        return $this->render('teaching_block/list.html.twig', [
            // Données passées à la vue
            'info' => $info,
            'form' => $form->createView()
        ]);
    }

    #[Route(path:'/teaching_block/{id}/edit', name: 'teaching_block_edit', methods: ['GET', 'POST'])]
    public function edit(TeachingBlock $teachingBlock, Request $request, EntityManagerInterface $entityManager) : Response 
    {
        $form = $this->createForm(TeachingBlockType::class, $teachingBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    // On POUSSE les données alors que "persist" c'est pour préciser qu'on veut ajouter ces nouvelles données
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

        return $this->render('teaching_block/edit.html.twig', [
            'form' => $form,
            'teachingBlock' => $teachingBlock,
        ]);
    }
}
