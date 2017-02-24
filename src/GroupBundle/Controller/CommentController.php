<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\Comment;
use GroupBundle\Entity\Topic;
use GroupBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class CommentController extends Controller
{
    /**
     * @Route("/comment/{id}/new", name="comment_new")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function newAction(Request $request, Topic $topic)
    {
        $form = $this->createForm(CommentType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Comment $comment */
            $comment = $form->getData();
            $comment->setTopic($topic);
            $comment->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('topic_show', ['id' => $topic->getId()]);
        }

        return $this->render('GroupBundle:Comment:new.html.twig', [
            'topic' => $topic,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @param Topic $topic
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newFormAction(Topic $topic)
    {
        $form = $this->createForm(CommentType::class);

        return $this->render('GroupBundle:Comment:new_form.html.twig', [
            'topic' => $topic,
            'form'  => $form->createView()
        ]);
    }
}