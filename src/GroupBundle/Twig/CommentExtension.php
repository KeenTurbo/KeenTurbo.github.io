<?php

namespace GroupBundle\Twig;

use GroupBundle\Entity\Comment;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class CommentExtension extends \Twig_Extension
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * CommentExtension constructor.
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
            new \Twig_SimpleFunction('can_edit_comment', [$this, 'canEditComment']),
            new \Twig_SimpleFunction('can_delete_comment', [$this, 'canDeleteComment'])
        ];
    }

    /**
     * @param Comment $comment
     *
     * @return bool
     */
    public function canEditComment(Comment $comment)
    {
        return $this->authorizationChecker->isGranted('edit', $comment);
    }

    /**
     * @param Comment $comment
     *
     * @return bool
     */
    public function canDeleteComment(Comment $comment)
    {
        return $this->authorizationChecker->isGranted('delete', $comment);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'comment_extension';
    }
}