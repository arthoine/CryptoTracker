<?php

namespace App\Repository;

use App\Entity\CryptoWallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CryptoWallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method CryptoWallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method CryptoWallet[]    findAll()
 * @method CryptoWallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptoWalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoWallet::class);
    }

    // /**
    //  * @return CryptoWallet[] Returns an array of CryptoWallet objects
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
    public function findOneBySomeField($value): ?CryptoWallet
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
