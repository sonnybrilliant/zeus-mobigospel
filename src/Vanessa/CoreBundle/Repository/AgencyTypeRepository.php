<?php

namespace Vanessa\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AgencyTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AgencyTypeRepository extends EntityRepository
{

    /**
     * Get by name
     *
     * @param string $name
     * @return type
     */
    public function getByName($name)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.type = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getSingleResult();
    }

}
