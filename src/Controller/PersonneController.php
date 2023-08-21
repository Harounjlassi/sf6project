<?php

namespace App\Controller;


use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/', 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig', ['personne' => $personnes]);


    }

    #[Route('/all', 'personne.list')]
    public function indexAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->findBy(['firstname' => 'jean'], ['age' => 'ASC'], 3, 1);
        return $this->render('personne/index.html.twig', ['personne' => $personne]);


    }

    #[Route('/alls/{page?1}/{nbre?12}', 'personne.list.alls')]
    public function indexAllPagination(ManagerRegistry $doctrine, $page, $nbre): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $nbPersonne=$repository->count([]);
        $nbPage=ceil($nbPersonne/$nbre);
        $personne = $repository->findBy([], [], $nbre, ($page - 1) * $nbre);
        return $this->render('personne/index.html.twig', ['personne' => $personne,
            'isPaginated'=>true,
            'nbrePage'=>$nbPage,
            'page'=>$page,
            'nbre'=>$nbre
        ]);


    }

    #[Route('/{id}', 'personne.detail')]
    public function detail(Personne $personne): Response
    {
//        $repository=$doctrine->getRepository(Personne::class);
//        $personne=$repository->find($id);
//        if(!$personne){
//            $this->addFlash('error',"la personne n'existe pas");
//        return $this->redirectToRoute('personne.list');
//
//        }
        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }

    #[Route('/add', name: 'app_personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        //$this->getDoctrine() : version sd <= 5
        $entityManager = $doctrine->getManager();
        $personne = new Personne();

        $personne->setFirstname("aziz");
        $personne->setName("jlassi");
        $personne->setAge(45);
        dump($entityManager);

        //Ajouter l'operation de la personne dans ma transcation
        $entityManager->persist($personne);
        //$entityManager->persist($personne2);


        // exucution la transaction todo
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }
}
