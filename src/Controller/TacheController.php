<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\AddTacheType;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TacheController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
        private StatutRepository $statutRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
    ){}

    #[Route('/projets/{id}/tache-add', name: 'app_tache_add')]
    public function index(int $id , Request $request): Response
    {
        $projet = $this->projetRepository->find($id);
        $tache = new Tache();
        $formAdd = $this->createForm(AddTacheType::class, $tache);
        $formAdd->handleRequest($request);
        if ($formAdd->isSubmitted()){
            $error = $this->validator->validate($formAdd);
            if (count($error) > 0) {
                return new Response('Le formulaire n\'est pas valide', Response::HTTP_BAD_REQUEST);
            }else
            {
                $this->entityManager->persist($tache);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_projet_view');
            }
        }


        return $this->render('tache/add.html.twig', [
            'controller_name' => 'TacheController',
            'formAdd' => $formAdd,
        ]);
    }
}
