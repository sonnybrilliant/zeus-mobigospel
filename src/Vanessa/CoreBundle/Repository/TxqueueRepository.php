<?php

namespace Vanessa\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TxqueueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TxqueueRepository extends EntityRepository
{

    /**
     * Get all txqueue query
     *
     * @return type
     */
    public function getAllTxqueueQuery($options)
    {

        $defaultOptions = array('searchText' => '',
            'filterBy' => '',
            'sort' => 't.id',
            'direction' => 'asc');

        foreach ($options as $key => $values) {
            if (!$values) {
                $options[$key] = $defaultOptions[$key];
            }
        }

        $qb = $this->createQueryBuilder('t')
            ->select('t');

        if (isset($options['status'])) {
            $qb->andWhere('t.status = :status')
                ->setParameter('status', $options['status']);
        }

        // search
        if (($options['searchText']) && ($options['searchText'] != 'search..')) {

            $qb->andWhere($qb->expr()->orx(
                    $qb->expr()->like('t.msisdn;', $qb->expr()->literal('%' . $options['searchText'] . '%')), 
                    $qb->expr()->like('t.body', $qb->expr()->literal('%' . $options['searchText'] . '%')), 
                    $qb->expr()->like('t.seqno', $qb->expr()->literal('%' . $options['searchText'] . '%'))                   
                ));
        }

        $qb->orderBy($options['sort'], $options['direction']);
        return $qb->getQuery()->execute();
    }    
    
}
