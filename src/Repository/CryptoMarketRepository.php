<?php

namespace App\Repository;

use App\Entity\CryptoMarket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CryptoMarket|null find($id, $lockMode = null, $lockVersion = null)
 * @method CryptoMarket|null findOneBy(array $criteria, array $orderBy = null)
 * @method CryptoMarket[]    findAll()
 * @method CryptoMarket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoMarketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoMarket::class);
    }

    // /**
    //  * @return CryptoMarket[] Returns an array of CryptoMarket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CryptoMarket
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
