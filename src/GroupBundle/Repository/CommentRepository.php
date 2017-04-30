<?php

namespace GroupBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GroupBundle\Entity\Comment;
use GroupBundle\Entity\Topic;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class CommentRepository extends EntityRepository
{
    /**
     * @param Topic $topic
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryLatestByTopic(Topic $topic)
    {
        return $this->createQueryBuilder('c')
            ->select('c,t,u')
            ->join('c.topic', 't')
            ->join('c.user', 'u')
            ->where('c.deletedAt IS NULL')
            ->andWhere('c.topic = :topic')
            ->orderBy('c.createdAt', 'ASC')
            ->setParameter('topic', $topic);
    }

    /**
     * @param Topic $topic
     * @param int   $page
     *
     * @return Pagerfanta
     */
    public function findPaginatedLatestByTopic(Topic $topic, $page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatestByTopic($topic), false));
        $paginator->setMaxPerPage(Comment::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
