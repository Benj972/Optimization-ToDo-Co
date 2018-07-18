<?php

namespace Tests\AppBundle\Fixtures;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader as ORMLoader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;

class DoctrineDataFixturesLoadingTest extends KernelTestCase
{
	/**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        /*$this->encoder = $kernel->getContainer()
        	->get("security.password_encoder");*/

        $loader = new ORMLoader();
        $loader->loadFromDirectory('src/AppBundle/DataFixtures/');
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }
    
    public function testSearchTask()
    {
        $tasks = $this->entityManager
            ->getRepository(Task::class)
            ->findAll()
        ;

        $this->assertCount(5, $tasks);
    }

    public function testSearchUser()
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll()
        ;

        $this->assertCount(2, $users);
    }
}