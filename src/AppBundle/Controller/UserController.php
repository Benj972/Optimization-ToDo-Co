<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Handler\CreateUserHandler;
use AppBundle\Handler\EditUserHandler;
use AppBundle\Handler\DeleteUserHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig', ['users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()]);
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(CreateUserHandler $handler, Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($handler->handle($form, $user)) {
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig',[
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(EditUserHandler $handler, User $user, Request $request)
    {
        $form =$this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($handler->handle($form)) {
            $this->addFlash('success', "L'utilisateur a bien été modifié");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig',[
            'form'  => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}/delete", name="user_delete")
     */
    public function deleteAction(DeleteUserHandler $handler, User $user, TokenStorageInterface $tokenStorage)
    {
        if ($user === $this->getUser()) {
            $handler->handle($user);
            // UserProvider to null
            $tokenStorage->setToken(null);
            $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');
            return $this->redirectToRoute('login');

        } elseif ($user !==  $this->getUser()) {
            $handler->handle($user);

            $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');
            return $this->redirectToRoute('user_list');
        }
    }
}
