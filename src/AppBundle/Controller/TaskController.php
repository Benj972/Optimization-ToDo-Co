<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Handler\CreateTaskHandler;
use AppBundle\Handler\EditTaskHandler;
use AppBundle\Handler\ToggleTaskHandler;
use AppBundle\Handler\DeleteTaskHandler;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(CreateTaskHandler $handler)
    {
        return $handler->handle($this->getUser());
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(EditTaskHandler $handler, Task $task)
    {
        $this->denyAccessUnlessGranted('edit', $task);
        return $handler->handle($task);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(ToggleTaskHandler $handler, Task $task)
    {
        return $handler->handle($task);
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(DeleteTaskHandler $handler, Task $task)
    {
        $this->denyAccessUnlessGranted('delete', $task);
        return $handler->handle($task);
    }
}
