<?php

namespace App\Controller;


use App\Entity\Personne;
use App\Entity\Profile;
use App\Event\AddPersonneEvent;
use App\Form\PersonneType;
use App\Service\Helpers;
use App\Service\MailerService;
use App\Service\PdfService;
use App\Service\UploaderService;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Type\TaskType;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\EventDispatcher\Event;


#[
    Route('personne'),
    IsGranted('ROLE_USER')
]
class PersonneController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
        private Helpers $helpers,
        private EventDispatcherInterface $dispatcher

    )
    {
    }

    #[Route('/', 'personne.list.root')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();
        dump($personnes);
        return $this->render('personne/index.html.twig', ['personne' => $personnes]);


    }

    #[Route('/pdf/{id}', name: "personne.pdf")]
    public function generatePdfPersonne(Personne $personne = null, PdfService $pdf)
    {
        $html = $this->render('personne/detail.html.twig', ['personne' => $personne]);
        $pdf->showPdfFile($html);


    }

    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'personne.list.age')]
    public function personneByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findPersonneByAgeInterval($ageMin, $ageMax);
        return $this->render('personne/index.html.twig'
            , [
                'personne' => $personnes

            ]
        );


    }

    #[Route('/stat/age/{ageMin}/{ageMax}', name: 'personne.list.stat')]
    public function statPersonne(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $stat = $repository->statsPersonneByAgeInterval($ageMin, $ageMax);
//        dd($stat[0]['ageMoyen']);
        return $this->render('personne/stat.html.twig',
            [
                'stat' => $stat[0],
                'ageMax' => $ageMax,
                'ageMin' => $ageMin
            ]);


    }

    #[Route('/all', 'personne.list')]
    public function indexAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->findBy(['firstname' => 'jean'], ['age' => 'ASC'], 3, 1);
        return $this->render('personne/index.html.twig', ['personne' => $personne]);


    }

    #[
        Route('/alls/{page?1}/{nbre?12}', 'personne.list.alls'),
        IsGranted("ROLE_USER")
    ]
    public function indexAllPagination(ManagerRegistry $doctrine, $page, $nbre): Response
    {

//        echo($this->helpers->sayCc());

            $repository = $doctrine->getRepository(Personne::class);
            $nbPersonne = $repository->count([]);
            $nbPage = ceil($nbPersonne / $nbre);
            $personne = $repository->findBy([], [], $nbre, ($page - 1) * $nbre);
            return $this->render('personne/index.html.twig', ['personne' => $personne,
                'isPaginated' => true,
                'nbrePage' => $nbPage,
                'page' => $page,
                'nbre' => $nbre
            ]);


    }


//    #[Route('/add', name: 'app_personne')]

    /**
     * @Route("/add", "personne.add")
     */

    public function addPersonne(ManagerRegistry $doctrine, Request $request, UploaderService $uploader)
    {
        //$this->getDoctrine() : version sd <= 5

//        $personne = new Personne();
//        $personne->setFirstname("aziz");
//        $personne->setName("jlassi");
//        $personne->setAge(45);
//        dump($entityManager);
//        $entityManager->flush();

//
        //Ajouter l'operation de la personne dans ma transcation
//        $entityManager->persist($personne);
//        $entityManager->persist($personne2);
//
//
//       // exucution la transaction todo
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $entityManager = $doctrine->getManager();

        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne,);
        $form->remove('createdAt');
        $form->remove('updatedAt');
//        dd($request);
        // mon formulaire va aller traiter la requte
        // est ce que mon formulaire a éte soumis
        //2 cas :


        $form->handleRequest($request);
////        //HandlRequest elle gère la requête et récupére l'objet.
        if ($form->isSubmitted() && $form->isValid()) {
            //si oui on ajoute l'objet de personne danslma base de donnée
//         dd($personne);
//            dd($form->getData()); // meme que dd($personne);
            //si non rediriger vers la liste de personne
            // afficher un message de success
            $personne->setCreatedBy($this->getUser());
            $brochureFile = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $directory = $this->getParameter('personne_directory');

                $personne->setImage($uploader->uploadfile($brochureFile, $directory));


            }
            $entityManager->persist($personne);

            $entityManager->flush();
            //on a crée notre evenement
            $addPersonneEvent =new AddPersonneEvent($personne);
            //on va maintenet le dispatcher
            $this->dispatcher->dispatch($addPersonneEvent,AddPersonneEvent::ADD_PERSONNE_EVENT);


            $this->addFlash("success", $personne->getName() . "a ete ahjouter avec succes ");
            return $this->redirectToRoute('personne.list');


        } else {
            // si non on affiche notre formualire

            return $this->renderForm('personne/add-personne.html.twig', ['form' => $form]);

        }


        //create un formulaire  voila la description objet formulaire PersonneType::class et voila l'object qui va etre l'image de ce formulaire la
//        $entityManager->flush();

    }


    #[
        Route('/delete/{id}', name: 'personne.delete'),
        isGranted('ROLE_ADMIN')
    ]
    public function delatPersonne(ManagerRegistry $doctrine, Personne $personne = null, MailerService $mailer): RedirectResponse
    {


        if ($personne) {
            // Si la personne existe => le supprimer et retourner un flash messahe de success

            $manager = $doctrine->getManager();
            //ajoute la finction de supprition dans la transaction
            $manager->remove($personne);
            //exucuter la transaction
            $manager->flush();




            $mailer->sendEmail();
            $this->addFlash('success', "personne  éte supprimer avec succés");


        } else {
            // sinon return un flash message d'erreur
            $this->addFlash('error', "Personne introuvable");


        }
        return $this->redirectToRoute('personne.list.alls');


    }

    #[Route('/update/{id}/{name}/{firstname}/{age}', 'personne.update')]
    public function updatePersonne(ManagerRegistry $doctrine, Personne $personne = null, $name, $firstname, $age): Response
    {
        if ($personne) {
            $personne->setName($name);
            $personne->setFirstname($firstname);
            $personne->setAge($age);

            //verifie que la personne existe

            $manger = $doctrine->getManager();
            $manger->persist($personne);
            $manger->flush();
            $this->addFlash('success', 'Personne updated with success ');

        } else {
            // sinon return un flash message d'erreur
            $this->addFlash('error', "Personne introuvable");
            //sinon message d'errue


        }
        return $this->redirectToRoute('personne.list.alls');


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


}
