<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

class DeleteManager
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
    public function delete($entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}