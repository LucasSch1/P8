<?php

namespace App\Controller;

use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class EmployeController extends AbstractController
{

    public function __construct(
        private EmployeRepository $employeRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,

    ){}

    #[Route('/employes/{id}/employe-edit', name: 'app_employe_edit')]
    public function editEmploye(int $id, EmployeRepository $employeRepository, Request $request): Response
    {
        $employe = $employeRepository->find($id);

        $formEditEmploye = $this->createForm(EmployeType::class, $employe);
        $formEditEmploye->handleRequest($request);
        if ($formEditEmploye->isSubmitted()){
            $errors = $this->validator->validate($formEditEmploye);
            if (count($errors) > 0) {
                return new Response('Le formulaire n\'est pas valide', Response::HTTP_BAD_REQUEST);

            }else
            {
                $this->entityManager->persist($employe);
                $this->entityManager->flush();
                return $this->redirectToRoute('app_employes');
            }

        }

        return $this->render('employe/edit.html.twig', [
            'employe' => $employe,
            'formEditEmploye' => $formEditEmploye->createView(),

        ]);

    }



    #[Route('/employes/{id}/employe-delete', name: 'app_employe_delete')]
    public function deleteEmploye(int $id, EmployeRepository $employeRepository, Request $request): Response
    {
        $employe = $employeRepository->find($id);

        if(!$employe){
            return $this->redirectToRoute('app_employes');
        }

        foreach ($employe->getTaches() as $tache){
            $tache->setEmploye(null);
        }

        $this->entityManager->remove($employe);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_employes');


    }
}
