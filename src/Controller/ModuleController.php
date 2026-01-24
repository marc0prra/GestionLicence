<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use PhpParser\Node\Expr\AssignOp\Mod;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TeachingBlockRepository;

class ModuleController extends AbstractController
{
    #[Route('/modules', name: 'module_index')]
    public function index(TeachingBlockRepository $teachingBlockRepository): Response
    {
        $blocks = $teachingBlockRepository->findAll();

        return $this->render('module/modules.html.twig', [
            'blocks' => $blocks,
        ]);
    }

    #[Route('/module/nouveau', name: 'app_module_new')]
    public function new(Request $request, EntityManagerInterface $em, TeachingBlockRepository $blockRepo): Response
    {
        $module = new Module();

        $blockId = $request->query->get('block_id');
        $blocTrouve = null;

        if ($blockId) {
            $blocTrouve = $blockRepo->find($blockId);
            if ($blocTrouve) {
                $module->setTeachingBlock($blocTrouve);
            }
        }
        $form = $this->createForm(ModuleType::class, $module, [
            'bloc_actuel' => $blocTrouve
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);
            $em->flush();
            $this->addFlash('success', 'Module créé avec succès.');
            return $this->redirectToRoute('module_index');
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

        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'module' => $module,
            'is_edit' => true
        ]);
    }

    #[Route('/module/{id}/delete', name: 'app_module_delete', methods: ['POST'])]
    public function delete(Request $request, Module $module, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $module->getId(), $request->request->get('_token'))) {
            $em->remove($module);
            $em->flush();
            $this->addFlash('success', 'Module supprimé.');
        }
        return $this->redirectToRoute('app_home');
    }
}
