<?php

namespace InfinitySystems\CalcBundle\Repository;


use Doctrine\ORM\EntityRepository;

class MoneyRepository extends EntityRepository
{
    public function sumAllMonths()
    {
        return $this->createQueryBuilder('m')
            ->select('sum(m.amount), m.monthYear')
            ->groupBy('m.monthYear')
            ->orderBy('m.monthYear')
            ->getQuery()
            ->execute();
    }

    public function getAllInMonth($month)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.monthYear = :month')
            ->setParameter('month', $month)
            ->orderBy('m.addDate')
            ->getQuery()
            ->execute();
    }

    public function sumInMonth($month)
    {
        return $this->createQueryBuilder('m')
            ->select('sum(m.amount)')
            ->andWhere('m.monthYear = :month')
            ->setParameter('month', $month)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumAllUnits()
    {
        return $this->createQueryBuilder('m')
            ->select('sum(m.amount), u.name')
            ->leftJoin('m.userId', 'u')
            ->groupBy('u.name')
            ->getQuery()
            ->execute();
    }
}