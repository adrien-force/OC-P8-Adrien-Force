<?php

namespace App\Controller;

use App\Entity\Employe;
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

    #[Route('/employe/edit/{id}', name: 'app_employe_edit', requirements: ['id' => '\d+'])]
    public function show
    (
        EmployeRepository      $employeRepository,
        Request                $request,
        EntityManagerInterface $em,
        int                    $id = null
    ): Response
    {
        $employe = $id ? $employeRepository->find($id) : new Employe();

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($employe);
            $em->flush();

            //Show a popup message to confirm the update to the user
        }

        return $this->render('employe/employe.html.twig', [
            'form' => $form->createView(),
            'employe' => $employe
        ]);
    }

    #[Route('/employe/remove/{id}', name: 'app_employe_remove', requirements: ['id' => '\d+'])]
    public function remove
    (
        EmployeRepository      $employeRepository,
        int                    $id,
        EntityManagerInterface $em
    ): Response
    {
        $employe = $employeRepository->find($id);
        if (!$employe) {
            return $this->redirectToRoute('app_employe_index');
        }

        $em->remove($employe);
        $em->flush();

        //Show a popup message to confirm the deletion to the user

        return $this->redirectToRoute('app_employe_index');
    }
}
