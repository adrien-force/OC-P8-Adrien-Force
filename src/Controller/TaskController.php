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

    #[Route('/task/edit/{projectId}/{taskId}', name: 'app_project_task_edit')]
    public function add
    (
        Request        $request,
        EntityManagerInterface $em,
        int            $taskId = null,
        int            $projectId = null
    )
    {
        $task = $taskId ? $em->getRepository(Task::class)->find($taskId) : new Task();
        
        $project = $em->getRepository(Project::class)->find($projectId);
        $task->setProject($project);

        $form = $this->createForm(TaskAddType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();
            $this->redirectToRoute('app_project_show', ['projectId' => $projectId]);
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView(),
            'task' => $task
        ]);
    }

    #[Route('/task/delete/{taskId}', name: 'app_task_delete')]
    public function delete
    (
        EntityManagerInterface $em,
        int            $taskId
    ) : Response
    {
        $task = $em->getRepository(Task::class)->find($taskId);
        $projectId = $task->getProject()->getId();
        $em->remove($task);
        $em->flush();
        return $this->redirectToRoute('app_project_show', ['projectId' => $projectId]);
    }
}
