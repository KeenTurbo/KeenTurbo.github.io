<?php

namespace GroupBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GroupBundle\Entity\Group;
use GroupBundle\Entity\Topic;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryLatest()
    {
        return $this->createQueryBuilder('t')
            ->select('t,u,g')
            ->join('t.user', 'u')
            ->join('t.group', 'g')
            ->where('t.deletedAt IS NULL')
            ->orderBy('t.touchedAt', 'DESC');
    }

    /**
     * @param Group $group
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function queryLatestByGroup(Group $group)
    {
        return $this->queryLatest()
            ->andWhere('t.group = :group')
            ->setParameter('group', $group);
    }

    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findPaginatedLatest($page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest()));
        $paginator->setMaxPerPage(Topic::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /**
     * @param Group $group
     * @param int   $page
     * @param int   $limit
     *
     * @return Pagerfanta
     */
    public function findPaginatedLatestByGroup(Group $group, $page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatestByGroup($group)));
        $paginator->setMaxPerPage(Topic::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /**
     * @param Group $group
     * @param int   $limit
     *
     * @return array
     */
    public function findLatestByGroup(Group $group, $limit = Topic::NUM_ITEMS)
    {
        return $this->queryLatestByGroup($group)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
