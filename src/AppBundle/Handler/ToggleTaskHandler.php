<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class ToggleTaskHandler
{ 
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * ToggleTaskHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Task $task
     */
    public function handle($task)
    {
        $task->toggle(!$task->isDone());
        $this->manager->flush();
    }
}
