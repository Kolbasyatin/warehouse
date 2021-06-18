<?php

namespace App\Repository;

use App\Entity\Pallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pallet[]    findAll()
 * @method Pallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pallet::class);
    }

    // /**
    //  * @return Pallet[] Returns an array of Pallet objects
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
    public function findOneBySomeField($value): ?Pallet
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
