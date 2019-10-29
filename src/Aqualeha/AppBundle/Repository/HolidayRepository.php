<?php

namespace Aqualeha\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class HolidayRepository extends EntityRepository
{
    public function findByYear($year)
    {
        return $this->createQueryBuilder('h')
            ->where('h.date LIKE :year')
            ->andWhere('h.country = 1')
            ->setParameter('year', $year . '%')
            ->getQuery()
            ->getResult();
    }
}