<?php

namespace GroupBundle\Twig;

use GroupBundle\Entity\Topic;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicExtension extends \Twig_Extension
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * TopicExtension constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('group_can_edit_topic', [$this, 'canEditTopic']),
            new \Twig_SimpleFunction('group_can_delete_topic', [$this, 'canDeleteTopic'])
        ];
    }

    /**
     * @param Topic $topic
     *
     * @return bool
     */
    public function canEditTopic(Topic $topic)
    {
        return $this->authorizationChecker->isGranted('edit', $topic);
    }

    /**
     * @param Topic $topic
     *
     * @return bool
     */
    public function canDeleteTopic(Topic $topic)
    {
        return $this->authorizationChecker->isGranted('delete', $topic);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'topic_extension';
    }
}