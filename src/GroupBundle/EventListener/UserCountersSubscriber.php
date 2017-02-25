<?php

namespace GroupBundle\EventListener;

use Doctrine\ORM\EntityManager;
use GroupBundle\Entity\Comment;
use GroupBundle\Entity\Topic;
use GroupBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class UserCountersSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * UserCountersSubscriber constructor.
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
            Events::TOPIC_CREATED   => 'onTopicCreated',
            Events::TOPIC_DELETED   => 'onTopicDeleted',
            Events::COMMENT_CREATED => 'onCommentCreated',
            Events::COMMENT_DELETED => 'onCommentDeleted'
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function onTopicCreated(GenericEvent $event)
    {
        /** @var Topic $topic */
        $topic = $event->getSubject();

        $user = $topic->getUser();
        $user->incrementNumTopics(1);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param GenericEvent $event
     */
    public function onTopicDeleted(GenericEvent $event)
    {
        /** @var Topic $topic */
        $topic = $event->getSubject();

        $user = $topic->getUser();
        $user->decrementNumComments(1);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param GenericEvent $event
     */
    public function onCommentCreated(GenericEvent $event)
    {
        /** @var Comment $comment */
        $comment = $event->getSubject();

        $user = $comment->getUser();
        $user->incrementNumComments(1);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param GenericEvent $event
     */
    public function onCommentDeleted(GenericEvent $event)
    {
        /** @var Comment $comment */
        $comment = $event->getSubject();

        $user = $comment->getUser();
        $user->decrementNumComments(1);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}