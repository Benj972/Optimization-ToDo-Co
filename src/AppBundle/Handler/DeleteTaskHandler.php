<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class DeleteTaskHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * DeleteTaskHandler constructor.
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
        $this->manager->remove($task);
        $this->manager->flush();
    }
}
