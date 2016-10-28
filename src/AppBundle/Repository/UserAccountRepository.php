<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserAccountRepository extends EntityRepository
{
    public function findMostRecentUsers($max = 5)
    {
        $query = $this
          ->createQueryBuilder('u')
          ->select('u.id, u.nickname as username')
          ->orderBy('u.registeredAt', 'DESC')
          ->setMaxResults($max)
          ->getQuery()
        ;
        
        return $query->getArrayResult();
    }
}