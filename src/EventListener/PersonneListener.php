<?php

namespace App\EventListener;

use App\Event\AddPersonneEvent;
use Psr\Log\LoggerInterface;

class PersonneListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onAddPersonneListener(AddPersonneEvent $evnet){
        $this->logger->debug("jes uis entrain d'ecouter l'venment personne.add et la personne ajouter".$evnet->getPersonne()->getName());
    }

}