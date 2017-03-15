<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\Comment;
use GroupBundle\Entity\Group;
use GroupBundle\Entity\Topic;
use GroupBundle\Events;
use GroupBundle\Form\TopicType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicController extends Controller
{
    /**
     * @Route("/group/{slug}/new", name="topic_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
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

            $event = new GenericEvent($topic);

            $this->get('event_dispatcher')->dispatch(Events::TOPIC_CREATED, $event);

            return $this->redirectToRoute('topic_show', ['id' => $topic->getId()]);
        }

        return $this->render('GroupBundle:Topic:new.html.twig', [
            'group' => $group,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/topic/{id}/edit", name="topic_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', topic)")
     */
    public function editAction(Request $request, Topic $topic)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic->setUpdatedAt(new \DateTime());

            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic_show', ['id' => $topic->getId()]);
        }

        return $this->render('GroupBundle:Topic:edit.html.twig', [
            'topic' => $topic,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/topic/{id}/delete", name="topic_delete", requirements={"id": "\d+"})
     * @Method("GET")
     * @Security("is_granted('delete', topic)")
     */
    public function deleteAction(Topic $topic)
    {
        $topic->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($topic);
        $entityManager->flush();

        $event = new GenericEvent($topic);

        $this->get('event_dispatcher')->dispatch(Events::TOPIC_DELETED, $event);

        $this->addFlash('success', '主题已删除');

        return $this->redirectToRoute('group_show', ['slug' => $topic->getGroup()->getSlug()]);
    }

    /**
     * @Route("/topic/{id}", name="topic_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction(Topic $topic)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $topic->incrementNumViews(1);

        $entityManager->flush();

        $comments = $entityManager->getRepository(Comment::class)->findLatestByTopic($topic);

        $latestTopics = $entityManager->getRepository(Topic::class)->findBy(['group' => $topic->getGroup()], ['createdAt' => 'DESC'], 10);

        return $this->render('GroupBundle:Topic:show.html.twig', [
            'topic'        => $topic,
            'comments'     => $comments,
            'latestTopics' => $latestTopics
        ]);
    }
}