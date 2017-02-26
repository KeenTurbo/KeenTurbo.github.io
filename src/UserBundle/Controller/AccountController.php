<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UserBundle\Form\ChangePasswordType;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class AccountController extends Controller
{
    /**
     * @Route("/account", name="account_index")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('UserBundle:Account:index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/account/edit-password", name="account_edit_password")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editPasswordAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $encodedPassword = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('account_index');
        }

        return $this->render('UserBundle:Account:edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}