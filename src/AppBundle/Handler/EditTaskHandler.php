<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class EditTaskHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * EditTaskHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Task $task
     * @param FormInterface $form
     */
    public function handle($form, $task)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($task);
            $this->manager->flush();
            
            return true;
        }

        return false;
    }
}
