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
        $qb = $this->createQueryBuilder('c')
            ->where('c.deletedAt IS NULL')
            ->andWhere('c.topic = :topic')
            ->orderBy('c.createdAt', 'ASC')
            ->setParameter('topic', $topic);

        return $qb->getQuery()->getResult();
    }
}
