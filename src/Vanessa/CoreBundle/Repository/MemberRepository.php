<?php

namespace Vanessa\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MemberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MemberRepository extends EntityRepository
{

    /**
     * Get all members query
     *
     * @return type
     */
    public function getAllMembersQuery($options)
    {

        $defaultOptions = array('searchText' => '',
            'filterBy' => '',
            'sort' => 'm.firstName',
            'direction' => 'asc');

        foreach ($options as $key => $values) {
            if (!$values) {
                $options[$key] = $defaultOptions[$key];
            }
        }

        $qb = $this->createQueryBuilder('m');
        $qb->select();

        if (isset($options['filterBy'])) {
            if (isset($options['status'])) {
                $qb->andWhere('m.status =:status')
                    ->setParameter('status', $options['status']);
            }
        }

        if ((isset($options['filterBy'])) && ($options['filterBy'] == '')) {
            $qb->andWhere('m.isDeleted =:status')
                ->setParameter('status', false);
        }

        // search
        if ($options['searchText']) {
            if ($options['searchText'] != "search..") {
                $qb->andWhere($qb->expr()->orx(
                        $qb->expr()->like('m.firstName', $qb->expr()->literal('%' . $options['searchText'] . '%')), $qb->expr()->like('m.lastName', $qb->expr()->literal('%' . $options['searchText'] . '%')), $qb->expr()->like('m.email', $qb->expr()->literal('%' . $options['searchText'] . '%')), $qb->expr()->like('m.mobileNumber', $qb->expr()->literal('%' . $options['searchText'] . '%'))
                    ));
            }
        }

        $qb->orderBy($options['sort'], $options['direction']);
        return $qb->getQuery()->execute();
    }

    /**
     * Get all members query
     *
     * @return type
     */
    public function getAllAgencyMembersQuery($options)
    {

        $defaultOptions = array('searchText' => '',
            'filterBy' => '',
            'sort' => 'm.id',
            'direction' => 'asc');

        foreach ($options as $key => $values) {
            if (!$values) {
                $options[$key] = $defaultOptions[$key];
            }
        }

        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.agency = :agency')
            ->andWhere('m.isDeleted = :deleted')
            ->setParameters(array(
            'agency' => $options['agency'],
            'deleted' => false,
            ));

        //filterby
        if (isset($options['filterBy'])) {
            if (isset($options['status'])) {
                $qb->andWhere('m.status =:status')
                    ->setParameter('status', $options['status']);
            }
        }

        // search
        if ($options['searchText']) {
            if ($options['searchText'] != "search..") {
                $qb->andWhere($qb->expr()->orx(
                        $qb->expr()->like('m.firstName', $qb->expr()->literal('%' . $options['searchText'] . '%')), $qb->expr()->like('m.lastName', $qb->expr()->literal('%' . $options['searchText'] . '%')), $qb->expr()->like('m.email', $qb->expr()->literal('%' . $options['searchText'] . '%')), $qb->expr()->like('m.mobileNumber', $qb->expr()->literal('%' . $options['searchText'] . '%'))
                    ));
            }
        }

        $qb->orderBy($options['sort'], $options['direction']);
        return $qb->getQuery()->execute();
    }

}

