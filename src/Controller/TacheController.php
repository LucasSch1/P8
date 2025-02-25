<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TacheController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
        private StatutRepository $statutRepository,
    ){}

    #[Route('/projets/{id}/tache-add', name: 'app_tache_add')]
    public function index(int $id): Response
    {
        $projet = $this->projetRepository->find($id);
        return $this->render('tache/add.html.twig', [
            'controller_name' => 'TacheController',
        ]);
    }
}
