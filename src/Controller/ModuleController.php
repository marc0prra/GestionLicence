<?php 

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Module;     
use App\Form\ModuleType;  
use Symfony\Component\HttpFoundation\Request;

class ModuleController extends AbstractController
{
    // 1. ROUTE POUR CRÉER UN NOUVEAU MODULE (Formulaire vide)
    #[Route('/module/nouveau', name: 'app_module_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $module = new Module();
        // On passe null car pas de bloc défini
        $form = $this->createForm(ModuleType::class, $module, ['bloc_actuel' => null]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);
            $em->flush();
            $this->addFlash('success', 'Module créé avec succès.');
            return $this->redirectToRoute('app_home'); // Retour à la liste
        }

        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'is_edit' => false
        ]);
    }

    // 2. ROUTE POUR MODIFIER (Formulaire pré-rempli)
    // L'URL est /module/{id}, donc si on clique sur un module, on arrive ici
    #[Route('/module/{id}', name: 'app_module_edit')]
    public function edit(Module $module, Request $request, EntityManagerInterface $em): Response
    {
        // ICI : Symfony a automatiquement rempli $module grâce à l'ID dans l'URL
        
        $form = $this->createForm(ModuleType::class, $module, [
            // On passe le bloc existant pour que la liste déroulante soit correcte
            'bloc_actuel' => $module->getTeachingBlock() 
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de persist() en modification
            $em->flush(); 
            
            $this->addFlash('success', 'Module modifié avec succès.');
            return $this->redirectToRoute('app_home'); // Retour à la liste
        }

        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'module' => $module, // Pour afficher le titre dynamique
            'is_edit' => true    // Pour afficher le bouton Supprimer
        ]);
    }

    // 3. ROUTE SUPPRESSION
    #[Route('/module/{id}/delete', name: 'app_module_delete', methods: ['POST'])]
    public function delete(Request $request, Module $module, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getId(), $request->request->get('_token'))) {
            $em->remove($module);
            $em->flush();
            $this->addFlash('success', 'Module supprimé.');
        }
        return $this->redirectToRoute('app_home');
    }
}