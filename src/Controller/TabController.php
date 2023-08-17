<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb</d+>?2}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes= [];
        for($i=0 ;$i<$nb;$i++){
            $notes[$i]= rand(0,20);

        }
        return $this->render('tab/index.html.twig', [
            'notes' => $notes,
        ]);
    }
}
