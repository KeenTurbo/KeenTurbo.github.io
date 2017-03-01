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
class SettingsController extends Controller
{
    /**
     * @Route("/settings", name="settings_index")
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
     * @Route("/settings/password", name="settings_password")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function passwordAction(Request $request)
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

            $this->addFlash('success', '密码已更新');

            return $this->redirectToRoute('settings_index');
        }

        return $this->render('UserBundle:Account:edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}