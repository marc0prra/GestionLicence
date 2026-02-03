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
    // Route pour afficher la liste des modules
    #[Route('/modules', name: 'module_index')]
    public function index(TeachingBlockRepository $teachingBlockRepository): Response
    {
        // Récupérer tous les blocs d'enseignement avec leurs modules
        $blocks = $teachingBlockRepository->findAll();

        // Rendre la vue avec les blocs et leurs modules
        return $this->render('module/modules.html.twig', [
            'blocks' => $blocks,
        ]);
    }

    // Route pour créer un nouveau module
    #[Route('/modules/nouveau', name: 'app_module_new')]
    public function new(Request $request, EntityManagerInterface $em, TeachingBlockRepository $blockRepo): Response
    {
        // Créer une nouvelle instance de Module
        $module = new Module();

        // Vérifier si un bloc d'enseignement est passé en paramètre pour pré-remplir le formulaire
        $blockId = $request->query->get('block_id');
        $blocTrouve = null;

        // Si un bloc d'enseignement est spécifié, le récupérer et l'assigner au module
        if ($blockId) {
            $blocTrouve = $blockRepo->find($blockId);
            if ($blocTrouve) {
                $module->setTeachingBlock($blocTrouve);
            }
        }
        // Créer le formulaire avec le bloc d'enseignement actuel si disponible
        $form = $this->createForm(ModuleType::class, $module, [
            'bloc_actuel' => $blocTrouve
        ]);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer le nouveau module
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);
            $em->flush();
            $this->addFlash('success', 'Module créé avec succès.');
            return $this->redirectToRoute('module_index');
        }

        // Rendre la vue du formulaire de création de module
        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'is_edit' => false
        ]);
    }

    // Route pour éditer un module existant
    #[Route('/modules/{id}', name: 'app_module_edit')]
    public function edit(Module $module, Request $request, EntityManagerInterface $em): Response
    {
        // Créer le formulaire avec le bloc d'enseignement actuel du module
        $form = $this->createForm(ModuleType::class, $module, [
            'bloc_actuel' => $module->getTeachingBlock()
        ]);

        $form->handleRequest($request);
        // Si le formulaire est soumis et valide, enregistrer les modifications du module
        if ($form->isSubmitted() ) {
            if ($form->isValid()) {
                    $em->persist($module);
                $em->flush();
                $this->addFlash('success', 'Module modifié avec succès.');


                return $this->redirectToRoute('app_module_edit', ['id' => $module->getId()]);
            }
        }
        // Rendre la vue du formulaire d'édition de module
        return $this->render('module/form_module.html.twig', [
            'form' => $form->createView(),
            'module' => $module,
            'is_edit' => true
        ]);
    }
    #[Route('/modules/{id}/delete', name: 'app_module_delete', methods: ['POST'])]
    public function delete(Module $module, Request $request, EntityManagerInterface $em): Response
    {
        // Vérification de sécurité CSRF
        if ($this->isCsrfTokenValid('delete' . $module->getId(), $request->request->get('_token'))) {
            // Tentative de suppression du module
            try {
                $em->remove($module);
                $em->flush();
                $this->addFlash('success', 'Module supprimé avec succès.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Impossible de supprimer ce module car il est utilisé ailleurs.');
            }
        }
        // Redirection vers la liste des modules
        return $this->redirectToRoute('module_index');
    }
}
