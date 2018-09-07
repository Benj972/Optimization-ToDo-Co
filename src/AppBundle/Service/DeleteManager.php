<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

/*
 *  This class is called to delete an entity.
 */
class DeleteManager
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * DeleteManager constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Entity $entity
     */
    public function delete($entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}