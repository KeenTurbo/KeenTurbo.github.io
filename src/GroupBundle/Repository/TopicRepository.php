<?php

namespace GroupBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GroupBundle\Entity\Group;
use GroupBundle\Entity\Topic;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class TopicRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findLatest()
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t,u,g')
            ->join('t.user', 'u')
            ->join('t.group', 'g')
            ->where('t.deletedAt IS NULL')
            ->orderBy('t.touchedAt', 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Group $group
     *
     * @return array
     */
    public function findLatestByGroup(Group $group, $limit = Topic::NUM_ITEMS)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t,u,g')
            ->join('t.user', 'u')
            ->join('t.group', 'g')
            ->where('t.deletedAt IS NULL')
            ->andWhere('t.group = :group')
            ->orderBy('t.touchedAt', 'DESC')
            ->setParameter('group', $group)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
