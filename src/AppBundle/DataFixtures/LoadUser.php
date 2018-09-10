<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/*
 *  This class is responsible for loading users
 */
class LoadUser extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('User1');
        $user1->setPassword('password1');
        $user1->setEmail('user1@hotmail.fr');
        $user1->setRoles(['ROLE_USER']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('User2');
        $user2->setPassword('password2');
        $user2->setEmail('user2@hotmail.fr');
        $user2->setRoles(['ROLE_ADMIN']);
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }
}
