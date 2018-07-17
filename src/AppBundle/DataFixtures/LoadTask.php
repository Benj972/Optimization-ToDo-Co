<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadTask extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

    	$task1 = new Task();
        $task1->setTitle('Task1');
        $task1->setContent('Quidem inpares diu conmunitam conmunitam fore frequentibus propinqua inpares nostris tramitibus magnis conmunitam quidem fore petivere inpares milite tramitibus congressione.');
        $task1->setUser(Null);
        $task1->toggle(0);
        $manager->persist($task1);

        $task2 = new Task();
        $task2->setTitle('Task2');
        $task2->setContent('Quidem inpares diu conmunitam conmunitam fore frequentibus propinqua inpares nostris tramitibus magnis conmunitam quidem fore petivere inpares milite tramitibus congressione.');
        $task2->setUser(Null);
        $task2->toggle(1);
        $manager->persist($task2);

        $task3 = new Task();
        $task3->setTitle('Task3');
        $task3->setContent('Quidem inpares diu conmunitam conmunitam fore frequentibus propinqua inpares nostris tramitibus magnis conmunitam quidem fore petivere inpares milite tramitibus congressione.');
        $task3->setUser($this->getReference('user1'));
        $task3->toggle(1);
        $manager->persist($task3);

        $task4 = new Task();
        $task4->setTitle('Task4');
        $task4->setContent('Quidem inpares diu conmunitam conmunitam fore frequentibus propinqua inpares nostris tramitibus magnis conmunitam quidem fore petivere inpares milite tramitibus congressione.');
        $task4->setUser($this->getReference('user1'));
        $task4->toggle(1);
        $manager->persist($task4);

        $task5 = new Task();
        $task5->setTitle('Task5');
        $task5->setContent('Quidem inpares diu conmunitam conmunitam fore frequentibus propinqua inpares nostris tramitibus magnis conmunitam quidem fore petivere inpares milite tramitibus congressione.');
        $task5->setUser($this->getReference('user2'));
        $task5->toggle(1);
        $manager->persist($task5);

    	$manager->flush();
    
    }

    public function getDependencies()
    {
        return [
        LoadUser::class,
        ];
    }
}