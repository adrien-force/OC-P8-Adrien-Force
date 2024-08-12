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

    #[Route('/employe/edit/{id}', name: 'app_employe_edit')]
    public function edit
    (
        Request                $request,
        EntityManagerInterface $em,
        Employe                $employe
    ): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($employe);
            $em->flush();
            $this->addFlash('success', 'Le collaborateur a bien été mis à jour.');
            return $this->redirectToRoute('app_employe_index');

        }

        return $this->render('employe/employe.html.twig', [
            'form' => $form->createView(),
            'employe' => $employe
        ]);
    }

    #[Route('/employe/add', name: 'app_employe_add')]
    public function add
    (
        Request                $request,
        EntityManagerInterface $em
    ): Response
    {
        $employe = new Employe();

        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($employe);
            $em->flush();
            $this->addFlash('success', 'Le collaborateur a bien été ajouté.');
            return $this->redirectToRoute('app_employe_index');
        }

        return $this->render('employe/employe.html.twig', [
            'form' => $form->createView(),
            'employe' => $employe
        ]);
    }

    #[Route('/employe/remove/{id}', name: 'app_employe_remove', requirements: ['id' => '\d+'])]
    public function remove
    (
        Employe                $employe,
        EntityManagerInterface $em
    ): Response
    {
        if (!$employe) {
            return $this->redirectToRoute('app_employe_index');
        }

        $em->remove($employe);
        $em->flush();

        //Show a popup message to confirm the deletion to the user

        return $this->redirectToRoute('app_employe_index');
    }
}
