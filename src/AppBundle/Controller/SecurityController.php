<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->render('security/login.html.twig', array(
            'last_username' => $this->get('security.authentication_utils')->getLastUsername(),
            'error'         => $this->get('security.authentication_utils')->getLastAuthenticationError(),
        ));
    }
}
