<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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


    /*Le routeur de Symfony requirements et ordre des routes
    =>les routes specifiques apres les routes generiques
    "Les premier route gagne toujours"

    */



    #[Route('/sayhello', name: 'say')]
    public function sayhello(): Response
    {
        $rand = rand(0, 10);
        if ($rand == 3) {

            return $this->redirectToRoute('first');


        }
        return $this->forward('App\Controller\FirstController::index');
    }

//    #[Route('/sayhello/{nom}/{prenom}', name: 'say.welcome')]
    public function hello(Request $request,$nom,$prenom): Response
    {

        return $this->render('first/hello.html.twig', [
            'nom'=>$nom,
                'prenom'=>$prenom,
                'path'=>'     '
            ]

        );
    }
    #[Route('/multi/{entier1<\d+>}/{entier2<\d+>}',
        name: 'multiplication',
        //requirements: ['entier1'=>'\d+','entier2'=>'\d+']
    )]
    public function multiplication($entier1, $entier2)
    {
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");


   }
//    #[Route('{maVar}',name:'test.order.route')]
//    public function testRoute($maVar): Response
//    {
//        return new Response(
//            "<html><body>$maVar</body></html>"
//
//        );
//
//    }
    #[Route('/tab/user', name: 'tab.users')]
    public function users(): Response
    {
        $users=[

            ['firstname'=>'haroun','name'=>'jlassi','age'=>39],
            ['firstname'=>'aziz','name'=>'jlassi','age'=>49],
            ['firstname'=>'fathi','name'=>'jlassi','age'=>19],

        ];
//dd($users);
        return $this->render('first/users.html.twig', [
                'users'=>$users

            ]

        );
    }
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        $users=[

            ['firstname'=>'haroun','name'=>'jlassi','age'=>39],
            ['firstname'=>'aziz','name'=>'jlassi','age'=>49],
            ['firstname'=>'fathi','name'=>'jlassi','age'=>19],

        ];

        return $this->render('template.html.twig');
    }


}

