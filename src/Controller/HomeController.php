<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{


    public function __construct(
        private ProjetRepository $projetRepository,
    ){}


    #[Route('/projets', name: 'app_home')]
    public function index(): Response
    {
        $projets = $this->projetRepository->findAll();
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'projets' => $projets,
        ]);
    }

    #[Route('/employes', name: 'app_employes')]
    public function showEmployesPage(): Response
    {
        return $this->render('employes.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
