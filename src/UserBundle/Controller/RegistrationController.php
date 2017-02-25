<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $encodedPassword = $this->get('security.password_encoder')->encodePassword($user, $user->getPlanPassword());
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Authentication
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $authToken = $this->get('security.authentication.manager')->authenticate($token);
            $this->get('security.token_storage')->setToken($authToken);

            return $this->redirect('/');
        }

        return $this->render('UserBundle:Registration:register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
