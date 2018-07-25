<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class DeleteUserHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * DeleteUserHandler constructor.
     * @param EntityManagerInterface $manager
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     */
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag, RouterInterface $router)
    {
        $this->manager = $manager;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @param User $user
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();

        $this->flashBag->add('success', 'L\'utilisateur a bien été supprimé.');

        return new RedirectResponse(
            $this->router->generate('user_list')
        );
    }
}