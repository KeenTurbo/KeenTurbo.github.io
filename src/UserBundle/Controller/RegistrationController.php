<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Events;
use UserBundle\Form\RegistrationType;

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
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $user->setName($user->getUsername());

            $encodedPassword = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $event = new GenericEvent($user);

            $this->get('event_dispatcher')->dispatch(Events::USER_CREATED, $event);

            $this->addFlash('success', '你已经成功注册');

            return $this->redirect('/');
        }

        return $this->render('UserBundle:Registration:register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
