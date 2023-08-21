<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigheritageController extends AbstractController
{
  #[Route('/twigheritage', name: 'app_twigheritage')]
    public function index(): Response
    {
        return $this->render('twigheritage/index.html.twig', [
            'controller_name' => 'TwigheritageController',
        ]);
    }

    #[Route('/twig/heritage', name: 'heritage')]
    public function heritage(): Response
    {
        return $this->render('twigheritage/index.html.twig', [
            'controller_name' => 'TwigheritageController',
        ]);
    }}
