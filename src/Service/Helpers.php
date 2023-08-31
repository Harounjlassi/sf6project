<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

class Helpers
{
    private $langue;

    public function __construct(private LoggerInterface $logger, Security $security)
    {

    }

    public function sayCc()
    {
         $this->logger->info('je dis cc');
        return 'cc';
    }
    public function getUser():User{
        return   $this->get('security.token_storage')->getToken()->getUser();



    }

}