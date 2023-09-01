<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class MailerService
{
    private $repyTO;
    public function __construct(private MailerInterface $mailer, $replyTo)
    {
        $this->repyTO=$replyTo;

    }


    public function sendEmail(){
//        dd($this->repyTO);
        $email = (new Email())
            ->from('yhhhgtub@gmail.com')
            ->to('jlassi.haroun@esprit.tn')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($this->repyTO)
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailerddd!')
            ->text('Sending emails is fun again!')
            ->html('<p>Seelistner Twig integration for better HTML integration!</p>');

         $this->mailer->send($email);

    }


}