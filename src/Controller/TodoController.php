<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("todo")]
// pour tout les URL todo is initialized : préfixe et valeur par défaut
class TodoController extends AbstractController
{
//    /**
//     * @Route("/todo", name="todo")
//     */
    #[Route('/', name: 'app_todo')]
    public function index(Request $request):Response
    {
        //aficher noter Todo tableau
        $session = $request->getsession();
        if (!$session->has('todos')) {

            $todo = ['correction' => 'corriger mes examens',
                'achat' => 'acheter avec clé USB',
                'cours' => 'Finaliser mes cours'

            ];
            $session->set('todos', $todo);
            $this->addFlash('info', "La Liste des todos viens d'etre initialiser");
        }

        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    #[Route(
        '/add/{name?si ma t7otech valeu rkif defaults: []}/{content?test}',
        name: 'todo.add',
        //defaults: ['name'=>'d','content'=>'sfb6']
        //ken ma7atitechye5o hethi par default
    )]
    public function addTodo(Request $request, $name, $content):RedirectResponse
    {
        //verfier si jai mo,nn tableau de todo dans la sesion
        $session = $request->getsession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('error', "La Liste des todos deja excite");


            } else {
                $todos[$name] = $content;
                $this->addFlash('success', "La Liste des todos a éte ajouté avec succes");
                $session->set('todos', $todos);


            }


        } else {
            $this->addFlash('error', "La Liste des todos n'estpas encore initialiser");


        }
        return $this->redirectToRoute('app_todo');


    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content):RedirectResponse
    {
        //verfier si jai mo,nn tableau de todo dans la sesion
        $session = $request->getsession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "Le todod'Id n'existe pas");


            } else {
                $todos[$name] = $content;
                $this->addFlash('success', "La Liste des todos a éte mofifié avec succes");
                $session->set('todos', $todos);


            }


        } else {
            $this->addFlash('error', "La Liste des todos n'est pas encore initialiser");


        }
        return $this->redirectToRoute('app_todo');


    }


    #[Route('/delate/{name}', name: 'todo.delate')]
    public function delateTodo(Request $request, $name):RedirectResponse
    {
        //verfier si jai mo,nn tableau de todo dans la sesion
        $session = $request->getsession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (!isset($todos[$name])) {
                $this->addFlash('error', "Le todod'Id n'existe pas");


            } else {
                unset($todos[$name]);
                $this->addFlash('success', "La Liste des todos a éte supprimer avec succes");
                $session->set('todos', $todos);


            }


        } else {
            $this->addFlash('error', "La Liste des todos n'est pas encore initialiser");


        }
        return $this->redirectToRoute('app_todo');


    }
    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request):RedirectResponse
    {
        $session=$request->getSession();
        $session->remove('todos');

        return $this->redirectToRoute('app_todo');


    }


}