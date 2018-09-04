<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class CreateTaskHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * CreateTaskHandler constructor.
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
    public function handle(FormInterface $form, $task): bool
    {

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($task);
            $this->manager->flush();
            return true;
        }

        return false;
    }
}
