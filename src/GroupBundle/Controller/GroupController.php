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
     * @Route("/group/{slug}", name="group_topic")
     * @Method("GET")
     */
    public function showAction(Group $group)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $topics = $entityManager->getRepository(Topic::class)->findLatestByGroup($group);

        return $this->render('GroupBundle:Group:show.html.twig', [
            'group'  => $group,
            'topics' => $topics
        ]);
    }
}
