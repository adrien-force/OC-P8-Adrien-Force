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

    #[Route('/task/add/{id}', name: 'app_task_add')]
    public function add
    (
        Request        $request,
        EntityManagerInterface $em,
        int            $id = null
    )
    {
        $task = new Task();
        $project = $em->getRepository(Project::class)->find($id);
        $task->setProject($project);
        $form = $this->createForm(TaskAddType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();
//            $this->addFlash('success', 'La tâche a bien été ajouté.');
            $this->redirectToRoute('app_project_show', ['id' => $task->getId()]);
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView(),
            'task' => $task
        ]);
    }
}