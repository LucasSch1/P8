<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
        private StatutRepository $statutRepository,
    ){}

    #[Route('/projets/{id}/view', name: 'app_projet_view')]
    public function index(int $id): Response
    {
        $projet = $this->projetRepository->find($id);
        $statuts = $this->statutRepository->findAll();
        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController',
            'projet' => $projet,
            'statuts' => $statuts,
        ]);
    }




}
