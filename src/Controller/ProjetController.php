<?php

namespace App\Controller;


use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\EmployeRepository;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProjetController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
        private StatutRepository $statutRepository,
        private EmployeRepository $employeRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
    ){}

    #[Route('/projets/{id}/view', name: 'app_projet_view')]
    public function index(int $id): Response
    {
        $projet = $this->projetRepository->find($id);
        $statuts = $this->statutRepository->findAll();

        $employesProjet = $projet->getEmployes();

        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController',
            'projet' => $projet,
            'statuts' => $statuts,
            'employesProjet' => $employesProjet,
        ]);
    }

    #[Route('/projets/projet-add', name: 'app_projet_add')]
    public function addProjet(Request $request): Response
    {
        $projet = new Projet();


        $allEmployes = $this->employeRepository->findAll();

        $formAddProjet = $this->createForm(ProjetType::class, $projet,[
            'allEmployes' => $allEmployes,
        ]);
        $formAddProjet->handleRequest($request);
        if ($formAddProjet->isSubmitted()){
            $errors = $this->validator->validate($formAddProjet);
            if (count($errors) > 0) {
                return new Response('Le formulaire n\'est pas valide', Response::HTTP_BAD_REQUEST);
            }else
            {
                $this->entityManager->persist($projet);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_projet_view', ['id' => $projet->getId()]);
            }
        }

        return $this->render('projet/add.html.twig', [
            'controller_name' => 'ProjetController',
            'projet' => $projet,
            'formAddProjet' => $formAddProjet->createView(),
        ]);
    }

    #[Route('/projets/{id}/projet-edit', name: 'app_projet_edit')]
    public function editProjet(Request $request, int $id): Response
    {
        $projet = $this->projetRepository->find($id);

        $allEmployes = $this->employeRepository->findAll();

        $employesProjet = $projet->getEmployes();


        $formAddProjet = $this->createForm(ProjetType::class, $projet,[
            'allEmployes' => $allEmployes,
            'employesProjet' => $employesProjet,
        ]);
        $formAddProjet->handleRequest($request);
        if ($formAddProjet->isSubmitted()){
            $errors = $this->validator->validate($formAddProjet);
            if (count($errors) > 0) {
                return new Response('Le formulaire n\'est pas valide', Response::HTTP_BAD_REQUEST);
            }else
            {
                $this->entityManager->persist($projet);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_projet_view', ['id' => $projet->getId()]);
            }
        }

        return $this->render('projet/edit.html.twig', [
            'controller_name' => 'ProjetController',
            'projet' => $projet,
            'formAddProjet' => $formAddProjet->createView(),
        ]);

    }






}
