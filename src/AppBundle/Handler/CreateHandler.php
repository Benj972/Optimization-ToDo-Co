<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class CreateHandler
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
     * @return bool
     */
    public function handle(FormInterface $form, $entity): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return true;
        }

        return false;
    }
}
