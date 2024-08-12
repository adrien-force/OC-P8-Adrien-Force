<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\TaskAddType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_task_index')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/task/edit/{id}', name: 'app_project_task_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        Task $task
    ): Response {
        $form = $this->createForm(TaskAddType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_project_show', ['id' => $task->getProject()->getId()]);
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView(),
            'task' => $task
        ]);
    }

    #[Route('/task/add/{id}', name: 'app_project_task_add')]
    public function add
    (
        Request        $request,
        EntityManagerInterface $em,
        Project            $project
    )
    {
        $task = new Task();
        $task->setProject($project);

        $form = $this->createForm(TaskAddType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView(),
            'task' => $task
        ]);
    }

    #[Route('/task/delete/{id}', name: 'app_task_delete')]
    public function delete
    (
        EntityManagerInterface $em,
        Task            $task
    ) : Response
    {
        $projectId = $task->getProject()->getId();
        $em->remove($task);
        $em->flush();
        return $this->redirectToRoute('app_project_show', ['id' => $projectId]);
    }
}
