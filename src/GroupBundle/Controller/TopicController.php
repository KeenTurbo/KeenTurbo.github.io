<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\Comment;
use GroupBundle\Entity\Group;
use GroupBundle\Entity\Topic;
use GroupBundle\Form\TopicType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicController extends Controller
{
    /**
     * @Route("/group/{id}/new_topic", name="topic_new", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request, Group $group)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $topic = new Topic();
        $topic->setGroup($group);
        $topic->setUser($this->getUser());

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('group_index', ['id' => $group->getId()]);
        }

        return $this->render('GroupBundle:Topic:new.html.twig', [
            'group' => $group,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/topic/{id}", name="topic_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction(Topic $topic)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('GroupBundle:Topic:show.html.twig', [
            'topic'    => $topic,
            'comments' => $comments
        ]);
    }
}