<?php

namespace App\Controller;

use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe_index')]
    public function index(EmployeRepository $employeRepository): Response
    {
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'employes' => $employeRepository->findAll()
        ]);
    }

    #[Route('/employe/{id}', name: 'app_employe_edit', requirements: ['id' => '\d+'])]
    public function show
    (
        EmployeRepository      $employeRepository,
        int                    $id,
        Request                $request,
        EntityManagerInterface $em
    ): Response
    {
        $employe = $employeRepository->find($id);
        if (!$employe) {
            return $this->redirectToRoute('app_employe_index');
        }

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($employe);
            $em->flush();

            //Show a popup mssage to confirm the update to the user
        }

        return $this->render('employe/employe.html.twig', [
            'form' => $form->createView(),
            'employe' => $employe
        ]);
    }
}
