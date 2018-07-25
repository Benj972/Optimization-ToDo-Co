<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Task;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class ToggleTaskHandler
{
  
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * ToggleTaskHandler constructor.
     * @param EntityManagerInterface $manager
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     */
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag, RouterInterface $router)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @param Task $task
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->manager->flush();
        // Different feedback message according to task 
        $feedback = $task->isDone() ? 'La tâche "%s" a bien été marquée comme terminée.' : 'La tâche "%s" a bien été marquée en cours.';
        $this->flashBag->add('success', sprintf($feedback, $task->getTitle()));

        return new RedirectResponse(
            $this->router->generate('task_list')
        );
    }
}