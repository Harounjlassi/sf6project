<?php

namespace App\Controller;

//use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        //aficher notre tableau Todo
        //si j ai mon tableau de todo dans ma session je ne fait que l'afficher
        ////sinon je l'initialise puis je l'affiche
        $session=$request->getSession();

   if(! $session->has('todos')){
       $todos=array(
           'achat' => 'TodoController',
           'cours' => 'finamiser mes cours',
           'correction' => 'corrifger me examens'

       );
       $session->set('todos',$todos);
   }
        return $this->render('todo/index.html.twig');
    }
    #[Route('/todo/{name}/{content}',name:'todo.add')]

    public function addTodo(Request $request,$name,$content){
// verifier si j ai mon tableau todo dans la session si oui

        // si non

    }
}
