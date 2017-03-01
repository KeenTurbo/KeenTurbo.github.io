<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\Comment;
use GroupBundle\Entity\Topic;
use GroupBundle\Events;
use GroupBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class CommentController extends Controller
{
    /**
     * @Route("/group/topic/{id}/comment", name="group_topic_comment_new")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request, Topic $topic)
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        $parent = null;
        if (null !== $parentId = $form->get('parent_id')->getData()) {
            $parent = $entityManager->getRepository(Comment::class)->find($parentId);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setTopic($topic);
            $comment->setUser($this->getUser());

            if (null !== $parent) {
                $comment->setParent($parent);
            }

            $entityManager->persist($comment);
            $entityManager->flush();

            $event = new GenericEvent($comment);

            $this->get('event_dispatcher')->dispatch(Events::COMMENT_CREATED, $event);

            return $this->redirectToRoute('group_topic_show', ['id' => $topic->getId(), '_fragment' => 'comment']);
        }

        return $this->render('GroupBundle:Comment:new.html.twig', [
            'topic'  => $topic,
            'parent' => $parent,
            'form'   => $form->createView()
        ]);
    }

    /**
     * @Route("/group/topic/comment/{id}/edit", name="group_topic_comment_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', comment)")
     */
    public function editAction(Request $request, Comment $comment)
    {
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setUpdatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('group_topic_show', ['id' => $comment->getTopic()->getId()]);
        }

        return $this->render('GroupBundle:Comment:edit.html.twig', [
            'comment' => $comment,
            'form'    => $form->createView()
        ]);
    }

    /**
     * @Route("/group/topic/comment/{id}/delete", name="group_topic_comment_delete")
     * @Method("GET")
     * @Security("is_granted('delete', comment)")
     */
    public function deleteAction(Comment $comment)
    {
        $comment->setDeletedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        $event = new GenericEvent($comment);

        $this->get('event_dispatcher')->dispatch(Events::COMMENT_DELETED, $event);

        return $this->redirectToRoute('group_topic_show', ['id' => $comment->getTopic()->getId()]);
    }

    /**
     * @param Topic $topic
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newFormAction(Request $request, Topic $topic)
    {
        $form = $this->createForm(CommentType::class);

        $parent = null;
        if (null !== $parentId = $request->get('comment_id')) {
            if (null !== $parent = $this->getDoctrine()->getRepository(Comment::class)->find($parentId)) {
                $form->get('parent_id')->setData($parent->getId());
            }
        }

        return $this->render('GroupBundle:Comment:new_form.html.twig', [
            'topic'  => $topic,
            'parent' => $parent,
            'form'   => $form->createView()
        ]);
    }
}