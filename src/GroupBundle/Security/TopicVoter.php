<?php

namespace GroupBundle\Security;

use GroupBundle\Entity\Topic;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use UserBundle\Entity\User;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicVoter extends Voter
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

        if (!$subject instanceof Topic) {
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

        /** @var Topic $topic */
        $topic = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($topic);
            case self::EDIT:
                return $this->canEdit($topic, $user);
            case self::DELETE:
                return $this->canDelete($topic, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Topic $topic
     *
     * @return bool
     */
    private function canView(Topic $topic)
    {
        if (!$topic->isDeleted()) {
            return true;
        }

        return false;
    }

    /**
     * @param Topic $topic
     * @param User  $user
     *
     * @return bool
     */
    private function canEdit(Topic $topic, User $user)
    {
        if (!$this->canView($topic)) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($topic->getUser() === $user) {
            return true;
        }

        return false;
    }

    /**
     * @param Topic $topic
     * @param User  $user
     *
     * @return bool
     */
    private function canDelete(Topic $topic, User $user)
    {
        return $this->canEdit($topic, $user);
    }
}
