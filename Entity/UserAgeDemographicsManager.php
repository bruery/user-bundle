<?php
/**
 * This file is part of the Bruery Platform.
 *
 * (c) Viktore Zara <viktore.zara@gmail.com>
 * (c) Mell Zamora <mellzamora@outlook.com>
 *
 * Copyright (c) 2016. For the full copyright and license information, please view the LICENSE  file that was distributed with this source code.
 */

namespace Bruery\UserBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;

class UserAgeDemographicsManager extends BaseEntityManager
{
    public function fetchAgeBracketCount()
    {
        $query = $this->getRepository()
            ->createQueryBuilder('ad')
            ->select('count(ad.collection) as ageBracketCount, c.name')
            ->leftJoin('ad.collection', 'c')
            ->groupBy('ad.collection')
            ->getQuery()
            ->useResultCache(true, 3600);

        try {
            return $query->getArrayResult();
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }

    public function fetchAgeBracketCountByGender()
    {
        $query = $this->getRepository()
            ->createQueryBuilder('ad')
            ->select('count(ad.collection) as ageBracketCount, c.name, u.gender')
            ->leftJoin('ad.collection', 'c')
            ->leftJoin('ad.user', 'u')
            ->groupBy('ad.collection', 'u.gender')
            ->orderBy('u.gender', 'DESC')
            ->getQuery()
            ->useResultCache(true, 3600);

        try {
            return $query->getArrayResult();
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }

    public function fetchAgeBracketCountTotal()
    {
        $query = $this->getRepository()
            ->createQueryBuilder('ad')
            ->select('count(ad.id) as ageBracketTotal')
            ->setMaxResults(1)
            ->getQuery()
            ->useResultCache(true, 3600);

        try {
            return $query->getSingleResult();
        } catch (\Exception $e) {
            return false;
        }
    }
}
