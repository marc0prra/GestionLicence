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
    #[Route('/module/nouveau', name: 'app_module_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module, ['bloc_actuel' => null]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);
            $em->flush();
            $this->addFlash('success', 'Module créé avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'is_edit' => false
        ]);
    }

    #[Route('/module/{id}', name: 'app_module_edit')]
    public function edit(Module $module, Request $request, EntityManagerInterface $em): Response
    {
        
        $form = $this->createForm(ModuleType::class, $module, [
            'bloc_actuel' => $module->getTeachingBlock() 
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); 
            
            $this->addFlash('success', 'Module modifié avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'module' => $module, 
            'is_edit' => true   
        ]);
    }

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