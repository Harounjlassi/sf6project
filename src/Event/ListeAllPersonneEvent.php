<?php

namespace App\Event;

use App\Entity\Personne;
use Symfony\Contracts\EventDispatcher\Event;


class ListeAllPersonneEvent extends Event
{
    const List_All_PERSONNE_EVENT ="personne.list.all";
    public function __construct(private int $nbPersonne){

    }
    public function getNbPersonne():int{
        return $this->nbPersonne;

}
}