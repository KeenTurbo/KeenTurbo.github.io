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
     * @Route("/", defaults={"page": 1}, name="homepage")
     * @Route("/p/{page}", requirements={"page": "[1-9]\d*"}, name="homepage_paginated")
     * @Method("GET")
     * @Cache(smaxage="5")
     */
    public function indexAction($page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $topics = $entityManager->getRepository(Topic::class)->findPaginatedLatest($page);

        $maxPages = ceil($topics->count() / Topic::NUM_ITEMS);

        if ($page > $maxPages) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Homepage:index.html.twig', [
            'topics'      => $topics,
            'maxPages'    => $maxPages,
            'currentPage' => $page,
        ]);
    }
}