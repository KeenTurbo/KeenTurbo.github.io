<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class PageController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @Method("GET")
     */
    public function contactAction()
    {
        return $this->render('AppBundle:Page:contact.html.twig');
    }

    /**
     * @Route("/terms", name="terms")
     * @Method("GET")
     */
    public function termsAction()
    {
        return $this->render('AppBundle:Page:terms.html.twig');
    }
}