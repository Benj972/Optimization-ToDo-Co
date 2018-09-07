<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Handler\CreateHandler;
use AppBundle\Handler\EditHandler;
use AppBundle\Service\ToggleTask;
use AppBundle\Service\DeleteManager;

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
    public function createAction(Request $request, CreateHandler $handler)
    {
        $task = new Task();
        $task->setUser($this->getUser());
        // build the form 
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        
        //call FormHandler
        if ($handler->handle($form, $task)) {
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }
        // render the template
        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(EditHandler $handler, Task $task, Request $request)
    {
        //check for "edit" access
        $this->denyAccessUnlessGranted('edit', $task);
        // build the form
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        //call FormHandler
        if ($handler->handle($form)) {
            $this->addFlash('success', 'La tâche a bien été modifiée.');
            return $this->redirectToRoute('task_list');
        }
        // render the template
        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(ToggleTask $toggle, Task $task)
    {
        //call service ToggleTask
        $toggle->switch($task);
        
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(DeleteManager $manager, Task $task)
    {
        //check for "delete" access
        $this->denyAccessUnlessGranted('delete', $task);
        //call service DeleteManager
        $manager->delete($task);

        $this->addFlash('success', 'La tâche a bien été supprimée.');
        
        return $this->redirectToRoute('task_list');
    }
}
