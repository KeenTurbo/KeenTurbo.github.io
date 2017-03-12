<?php

namespace GroupBundle\Security;

use GroupBundle\Entity\Comment;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class CommentVoter extends Voter
{
    const VIEW = 'view';

    const EDIT = 'edit';

    const DELETE = 'delete';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Comment $comment */
        $comment = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($comment);
            case self::EDIT:
                return $this->canEdit($comment, $user);
            case self::DELETE:
                return $this->canDelete($comment, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Comment $comment
     *
     * @return bool
     */
    private function canView(Comment $comment)
    {
        if (!$comment->isDeleted()) {
            return true;
        }

        return false;
    }

    /**
     * @param Comment $comment
     * @param User    $user
     *
     * @return bool
     */
    private function canEdit(Comment $comment, User $user)
    {
        if (!$this->canView($comment)) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($comment->getUser() === $user) {
            return true;
        }

        return false;
    }

    /**
     * @param Comment $comment
     * @param User    $user
     *
     * @return bool
     */
    private function canDelete(Comment $comment, User $user)
    {
        return $this->canEdit($comment, $user);
    }
}
