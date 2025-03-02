<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        private TacheRepository $tacheRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
    ){}

    private function checkIfProjetIsArchived(?Projet $projet): ?RedirectResponse
    {
        if(!$projet || $projet->isArchive()){
            $this->addFlash('error', 'Ce projet est archivé et ne peut pas être consulté.');
            return $this->redirectToRoute('app_home');
        }
        return null;
    }

    #[Route('/projets/{id}/tache-add', name: 'app_tache_add')]
    public function index(int $id , Request $request): Response
    {
        $projet = $this->projetRepository->find($id);
        $tache = new Tache();
        $tache->setProjet($projet);

        $employeProjet = $projet->getEmployes();

        $formAdd = $this->createForm(TacheType::class, $tache, [
            'employes' => $employeProjet,
        ]);
        $formAdd->handleRequest($request);
        if ($formAdd->isSubmitted()){
            $error = $this->validator->validate($formAdd);
            if (count($error) > 0) {
                return new Response('Le formulaire n\'est pas valide', Response::HTTP_BAD_REQUEST);
            }else
            {
                $this->entityManager->persist($tache);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_projet_view', ['id' => $projet->getId()]);
            }
        }


        return $this->render('tache/add.html.twig', [
            'controller_name' => 'TacheController',
            'formAdd' => $formAdd,
        ]);
    }


    #[Route('/projets/{id}/tache-edit', name: 'app_tache_edit')]
    public function editTache( Tache $tache, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = $tache->getProjet();
        $employeProjet = $projet->getEmployes();

        $formEdit = $this->createForm(TacheType::class, $tache, [
            'employes' => $employeProjet,
        ]);
        $formEdit->handleRequest($request);



        if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_projet_view', ['id' => $projet->getId()]);
        }

        return $this->render('tache/edit.html.twig', [

            'controller_name' => 'TacheController',
            'formEdit' => $formEdit->createView(),
            'projet' => $projet,
            'tache' => $tache,
        ]);
    }

    #[Route('/projets/{id}/tache-delete', name: 'app_tache_delete')]
    public function deleteTache(Tache $tache, int $id, EntityManagerInterface $entityManager): Response
    {
        $projet = $this->tacheRepository->find($id);
        $this->entityManager->remove($tache);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_projet_view', ['id' => $projet->getProjet()->getId()]);

    }

}
