<?php

namespace GroupBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GroupBundle\Entity\Topic;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class CommentRepository extends EntityRepository
{
    /**
     * @param Topic $topic
     *
     * @return array
     */
    public function findLatestByTopic(Topic $topic)
    {
        $query = $this->getEntityManager()
            ->createQuery('
            SELECT c
            FROM GroupBundle:Comment c
            WHERE c.deletedAt IS NULL
            AND c.topic = :topic
            ORDER BY c.createdAt ASC
        ')->setParameter('topic', $topic);

        return $query->getResult();
    }
}
