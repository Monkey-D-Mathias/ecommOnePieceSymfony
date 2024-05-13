<?php

namespace App\Repository;

use App\Entity\SalesOrderAddresses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalesOrderAddresses>
 *
 * @method SalesOrderAddresses|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesOrderAddresses|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesOrderAddresses[]    findAll()
 * @method SalesOrderAddresses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesOrderAddressesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalesOrderAddresses::class);
    }

//    /**
//     * @return SalesOrderAddresses[] Returns an array of SalesOrderAddresses objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SalesOrderAddresses
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
