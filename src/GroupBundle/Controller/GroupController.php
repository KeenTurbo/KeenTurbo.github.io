<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\Group;
use GroupBundle\Entity\Topic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class GroupController extends Controller
{
    /**
     * @Route("/group/{id}", name="group_index", requirements={"id": "\d+"})
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Group $group)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $topics = $entityManager->getRepository(Topic::class)->findBy(['group' => $group], ['createdAt' => 'DESC']);

        return $this->render('GroupBundle:Group:index.html.twig', [
            'group'  => $group,
            'topics' => $topics
        ]);
    }
}
