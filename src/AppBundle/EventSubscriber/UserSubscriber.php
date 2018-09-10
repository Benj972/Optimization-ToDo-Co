<?php

namespace AppBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;

/*
 * This class is used to manage password hashing
 */
class UserSubscriber implements EventSubscriber
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserSubscriber constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate'
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // Only act on User entity
        if ($entity instanceof User) {
            // Encode password
            $entity->setPassword($this->encoder->encodePassword($entity, $entity->getPassword()));
        }
    }
}
