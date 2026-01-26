<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
// Import indispensable pour que getFlashBag() soit reconnu
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagAwareSessionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private RequestStack $requestStack
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // On vérifie les deux types d'exceptions possibles pour un accès refusé
        // (Celle de la Sécurité et celle du noyau HTTP)
        if (!$exception instanceof AccessDeniedException && !$exception instanceof AccessDeniedHttpException) {
            return;
        }

        // CORRECTION DE L'ERREUR ICI :
        // On récupère la session
        $session = $this->requestStack->getSession();

        // On vérifie si cette session est capable de gérer des messages Flash
        if ($session instanceof FlashBagAwareSessionInterface) {
            $session->getFlashBag()->add(
                'error',
                'Accès refusé : Vous n\'avez pas les droits suffisants pour accéder à cette page.'
            );
        }

        // Redirection vers l'accueil
        $response = new RedirectResponse($this->urlGenerator->generate('app_login'));
        $event->setResponse($response);
    }
}