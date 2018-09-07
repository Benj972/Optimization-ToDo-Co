<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * This class allows to manage the task as realized or not.
 */
class ToggleTask
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
     * ToggleTask constructor.
     * @param EntityManagerInterface $manager
     * @param FlashBagInterface $flashbag
     */
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Task $task
     */
    public function switch($task)
    {
        $task->toggle(!$task->isDone());
        $this->manager->flush();

        // Different feedback message according to task
        $feedback = $task->isDone() ? 'La tâche "%s" a bien été marquée comme terminée.' : 'La tâche "%s" a bien été marquée en cours.'; 
        $this->flashBag->add('success', sprintf($feedback, $task->getTitle()));
    }
}