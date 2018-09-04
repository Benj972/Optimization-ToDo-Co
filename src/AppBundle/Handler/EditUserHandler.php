<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class EditUserHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * EditUserHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormInterface $form
     */
    public function handle($form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return true;
        }

        return false;
    }
}
