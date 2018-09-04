<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class DeleteUserHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * DeleteUserHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     */
    public function handle($user)
    {
            $this->manager->remove($user);
            $this->manager->flush();
    }
}
