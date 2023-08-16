<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        //aficher noter Todo tableau
        $session = $request->getsession();
        if (!$session->has('todos')) {

            $todo = ['correction' => 'corriger mes examens',
                'achat' => 'acheter avec clé USB',
                'cours' => 'Finaliser mes cours'

            ];
            $session->set('todos', $todo);
            $this->addFlash('info',"La Liste des todos viens d'etre initialiser");
        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request, $name, $content)
    {
        //verfier si jai mo,nn tableau de todo dans la sesion
        $session = $request->getsession();
        if($session->has('todos')){
            $todos=$session->get('todos');
            if (isset($todos[$name])){
                $this->addFlash('error',"La Liste des todos deja excite");



            }else{
                $todos[$name]=$content;
                $this->addFlash('success',"La Liste des todos a éte ajouté avec succes");
                $session->set('todos',$todos);


            }


        }else{
            $this->addFlash('error',"La Liste des todos n'estpas encore initialiser");


        }
        return $this->redirectToRoute('app_todo');


    }

}
