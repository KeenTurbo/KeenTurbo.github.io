<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use UserBundle\Entity\User;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class ProfileController extends Controller
{
    /**
     * @Route("/profile/{username}", name="user_profile")
     * @Method("GET")
     */
    public function indexAction(User $user)
    {
        return $this->render('UserBundle:Profile:index.html.twig', [
            'user' => $user
        ]);
    }
}