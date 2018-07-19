<?php

namespace AppBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class CreateUserHandler
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * CreateUserHandler constructor.
     * @param FormFactoryInterface $formFactory
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $manager
     * @param FlashBagInterface $flashBag
     * @param Environment $twig
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack, EntityManagerInterface $manager, FlashBagInterface $flashBag, Environment $twig, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->manager = $manager;
        $this->flashBag = $flashBag;
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @param User $user
     * @return RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle()
    {
        $user = new User();

        $form = $this->formFactory->create(UserType::class, $user)->handleRequest($this->requestStack->getCurrentRequest());
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);
            $this->manager->flush();
            $this->flashBag->add('success', "L'utilisateur a bien été ajouté.");
            return new RedirectResponse(
                $this->router->generate('user_list')
            );
        }

        return new Response($this->twig->render('user/create.html.twig', array(
            'form'  => $form->createView()
        )));
    }
}