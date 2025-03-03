<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{


    public function __construct(
        private ProjetRepository $projetRepository,
        private EmployeRepository $employeRepository,
    ){}

    #[Route('/', name: 'app_home_default')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/projets', name: 'app_home')]
    public function projets(): Response
    {
        $projets = $this->projetRepository->findBy(['archive'=>0]);
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'projets' => $projets,
        ]);
    }

    #[Route('/employes', name: 'app_employes')]
    public function showEmployesPage(): Response
    {
        $employes = $this->employeRepository->findAll();
        return $this->render('employe/employes.html.twig', [
            'controller_name' => 'HomeController',
            'employes' => $employes,
        ]);
    }
}
