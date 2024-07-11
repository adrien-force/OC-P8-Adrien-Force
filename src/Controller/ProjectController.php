<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/' , name: 'app_project')]
    #[Route('/index' , name: 'app_project_index')]

    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projectRepository->findAll()
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show')]
    public function show
    (
        ProjectRepository $projectRepository,
        StatusRepository $statusRepository,
        int $id,
    ): Response
    {
        if (!$projectRepository->find($id) ||
            !$statusRepository->findAll()) {
            return $this->redirectToRoute('app_project');
        }

        return $this->render('project/project.html.twig', [
            'controller_name' => 'ProjectController',
            'project' => $projectRepository->find($id),
            'status' => $statusRepository->findAll()
        ]);
    }

    #[Route('/project/{id}/remove', name: 'app_project_remove')]
    public function remove(ProjectRepository $projectRepository, int $id, EntityManagerInterface $em): Response
    {
        $project = $projectRepository->find($id);
        if (!$project) {
            return $this->redirectToRoute('app_project');
        }
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('app_project');
    }

    #[Route('/project/{id}/edit', name: 'app_project_edit')]
    public function edit(ProjectRepository $projectRepository, int $id, EntityManagerInterface $em): Response
    {
        $project = $projectRepository->find($id);
        if (!$project) {
            return $this->redirectToRoute('app_project');
        }

        //form

        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('app_project');
    }

    #[Route('/project/add', name: 'app_project_add')]
    public function add(EntityManagerInterface $em): Response
    {
        //
    }
}