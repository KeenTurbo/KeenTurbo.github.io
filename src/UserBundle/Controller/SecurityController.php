<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     * @Method({"GET", "POST"})
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('UserBundle:Security:login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error'         => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @Method("GET")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
}