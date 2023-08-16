<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
//    /**
//     * @return Response
//     * @Route('/first')
//     */

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
//        die('first');
        return $this->render('first/index.html.twig', [
                'name' => 'jlassi',
                'firstname' => 'haroun'


            ]


        );
    }
//        Return new Response(
//            content: "<head>
//<title>
//ma premierepage
//</title>
//<body><h1>hello syfony</h1></body>
//</head>"
//        );

    #[Route('/sayhello', name: 'say.hello')]
    public function sayhello(): Response
    {
        $rand = rand(0, 10);
        echo $rand;
        if ($rand == 3) {

            return $this->redirectToRoute('first');


        }
        return $this->forward('App\Controller\FirstController::index');
    }

}

