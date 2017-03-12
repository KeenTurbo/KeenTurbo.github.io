<?php

namespace GroupBundle\EventListener;

use Doctrine\ORM\EntityManager;
use GroupBundle\Entity\Topic;
use GroupBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class GroupCountersSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::TOPIC_CREATED => 'onTopicCreated',
            Events::TOPIC_DELETED => 'onTopicDeleted'
        ];
    }

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
     * @param GenericEvent $event
     */
    public function onTopicCreated(GenericEvent $event)
    {
        /** @var Topic $topic */
        $topic = $event->getSubject();
        $group = $topic->getGroup();
        $group->incrementNumTopics(1);

        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }

    /**
     * @param GenericEvent $event
     */
    public function onTopicDeleted(GenericEvent $event)
    {
        /** @var Topic $topic */
        $topic = $event->getSubject();
        $group = $topic->getGroup();
        $group->decrementNumTopics(1);

        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }
}