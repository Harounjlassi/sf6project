<?php

namespace App\EventListener;

use App\Event\AddPersonneEvent;
use App\Event\ListeAllPersonneEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;


class PersonneListener
{
    private $twig;

    public function __construct(private LoggerInterface $logger, \Twig\Environment $twig)
    {
        $this->twig = $twig;

    }

    public function onAddPersonneListener(AddPersonneEvent $evnet){
        $this->logger->debug("jes uis entrain d'ecouter l'venment personne.add et la personne ajouter".$evnet->getPersonne()->getName());
    }
    public function onListAllstat(ListeAllPersonneEvent $evnet){
        $this->logger->debug("le nombre de personne dans la base ".$evnet->getNbPersonne());
    }
    public function onListAllstat2(ListeAllPersonneEvent $evnet){
        $this->logger->debug("2 listener: le nombre de personne dans la base ".$evnet->getNbPersonne());
    }
    public function LogKernelRequest(KernelEvent $evnet){
        dd($evnet->getRequest());
    }
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedException) {
            // Appeler la méthode pour gérer l'exception d'accès refusé
            $this->handleAccessDeniedException($event, $exception);
        }
    }

    private function handleAccessDeniedException(ExceptionEvent $event, AccessDeniedException $exception)
    {
        // Faites ici ce que vous voulez en réponse à l'accès refusé
        $responseContent = $this->twig->render('accessDinied.html.twig', []);
        $response = new Response($responseContent, Response::HTTP_FORBIDDEN);
        $event->setResponse($response);
    }



}