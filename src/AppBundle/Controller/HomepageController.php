<?php

namespace AppBundle\Controller;

use GroupBundle\Entity\Topic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $topics = $entityManager->getRepository(Topic::class)->findLatest();

        return $this->render('AppBundle:Homepage:index.html.twig', [
            'topics' => $topics
        ]);
    }
}