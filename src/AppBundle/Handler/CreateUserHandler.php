<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class CreateUserHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * CreateUserHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     * @param FormInterface $form
     */
    public function handle($form, $user)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);
            $this->manager->flush();

            return true;
        }

        return false;
    }
}
