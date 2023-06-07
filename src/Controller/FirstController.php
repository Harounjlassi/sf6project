<?php

namespace App\Controller;

//use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;




class FirstController extends AbstractController
{

   /* /**
     * @Route("/first", name="first_index", methods={"GET"})
     */
    #[Route('/first/haroun', name: 'first')]
    public function index(): Response
    {
//        return new Response(
//            content: "<head>
//                            <title>
//                                ma premiere page
//                               </title>
//                        <body><H1> haroun is the best</H1></body>
//
//                        </head>"
//
//        );
        return $this->render('first/index.html.twig',[
            'name'=>  'jlassi',
            'firstname'=> 'haroun'

        ]);

    }


#[Route('/sayhello/{name}/{firstname}', name: 'say.hello')]
    public function sayhello(Request $request, $name,$firstname): Response
    {
//        $rand= rand(0,10);
//        echo  $rand;
//if ($rand== 3)
//{
//    return $this->redirectToRoute('first');
//}//       return $this->forward(controller: 'App\Controller\FirstController::index');
//        return $this->render('first/hello.html.twig',[
//            'name'=>  'jlassi',
//            'firstname'=> 'haroun'
//
//        ]);
    dd($request);
    return $this->render('first/hello.html.twig',[
        'name'=>$name,
        'firstname'=>$firstname
    ]);

    }
}
