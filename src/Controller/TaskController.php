<?php 

// src/Controller/TaskController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/test-composants', name: 'app_test_composants')]
    public function test(): Response
    {
        // Attention : Assure-toi que le nom du fichier ici correspond
        // exactement à celui que tu as créé dans le dossier templates
        return $this->render('components_test.html.twig');
    }
    
    #[Route('/tasks', name: 'app_task')]
    public function index(): Response
    {
        // On simule la structure de l'image avec un tableau
        $fakeData = [
            [
                'title' => 'Task Board',
                'children' => [
                    [
                        'title' => 'Projet Marketing',
                        'children' => [
                            ['title' => 'Campagne Email', 'children' => []], // Pas d'enfants = tableau vide
                            ['title' => 'Réseaux Sociaux', 'children' => []],
                        ]
                    ],
                    [
                        'title' => 'Développement Web',
                        'children' => [
                            [
                                'title' => 'Front-end',
                                'children' => [
                                    ['title' => 'Composants Vue.js', 'children' => []],
                                    ['title' => 'Intégration CSS', 'children' => []],
                                ]
                            ],
                            ['title' => 'Back-end', 'children' => []],
                        ]
                    ],
                    [
                        'title' => 'Administratif', 
                        'children' => [] 
                    ],
                ]
            ]
        ];

        return $this->render('task/index.html.twig', [
            'treeData' => $fakeData, // On passe le tableau à la vue
        ]);
    }
}