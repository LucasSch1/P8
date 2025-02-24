<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
    ){}

    #[Route('/projets/{id}/view', name: 'app_projet_view')]
    public function index(int $id): Response
    {
        $projet = $this->projetRepository->find($id);
        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController',
            'projet' => $projet,
        ]);
    }
}
