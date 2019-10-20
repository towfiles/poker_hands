<?php

namespace App\Repository;

use App\Entity\PokerHands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PokerHands|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokerHands|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokerHands[]    findAll()
 * @method PokerHands[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokerHandsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokerHands::class);
    }

    // /**
    //  * @return PokerHands[] Returns an array of PokerHands objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PokerHands
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
