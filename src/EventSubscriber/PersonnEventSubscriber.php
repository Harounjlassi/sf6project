<?php

namespace App\EventSubscriber;

use App\Event\AddPersonneEvent;
use App\Service\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersonnEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private MailerService $mailer)
    {
    }

    public static function getSubscribedEvents():array
    {
        // TODO: Implement getSubscribedEvents() method.
        return[AddPersonneEvent::ADD_PERSONNE_EVENT=>['OnAddPersonneEvent',3000]];
    }
    public function OnAddPersonneEvent(AddPersonneEvent $event):void{

        $this->mailer->sendEmail();

    }
}