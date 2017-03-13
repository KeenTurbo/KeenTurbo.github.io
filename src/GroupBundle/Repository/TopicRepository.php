<?php

namespace GroupBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GroupBundle\Entity\Group;

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
        $query = $this->getEntityManager()->createQuery('
            SELECT t
            FROM GroupBundle:Topic t
            WHERE t.deletedAt IS NULL
            ORDER BY t.touchedAt DESC
        ');

        return $query->getResult();
    }

    /**
     * @param Group $group
     *
     * @return array
     */
    public function findLatestByGroup(Group $group)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT t
            FROM GroupBundle:Topic t
            WHERE t.deletedAt IS NULL
            AND t.group = :group
            ORDER BY t.touchedAt DESC
        ')->setParameter('group', $group);

        return $query->getResult();
    }
}
