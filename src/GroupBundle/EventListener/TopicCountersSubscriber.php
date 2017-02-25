<?php

namespace GroupBundle\EventListener;

use Doctrine\ORM\EntityManager;
use GroupBundle\Entity\Comment;
use GroupBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicCountersSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * TopicCountersListener constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::COMMENT_CREATED => 'onCommentCreated',
            Events::COMMENT_DELETED => 'onCommentDeleted'
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onCommentCreated(GenericEvent $event)
    {
        /** @var Comment $comment */
        $comment = $event->getSubject();
        $topic = $comment->getTopic();
        $topic->incrementNumComments(1);

        $this->entityManager->persist($topic);
        $this->entityManager->flush();
    }

    /**
     * @param GenericEvent $event
     */
    public function onCommentDeleted(GenericEvent $event)
    {
        /** @var Comment $comment */
        $comment = $event->getSubject();
        $topic = $comment->getTopic();
        $topic->decrementNumComments(1);

        $this->entityManager->persist($topic);
        $this->entityManager->flush();
    }
}