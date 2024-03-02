<?php

namespace App\Repository;

use App\Entity\CategorieTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieTransport>
 *
 * @method CategorieTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieTransport[]    findAll()
 * @method CategorieTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieTransport::class);
    }

//    /**
//     * @return CategorieTransport[] Returns an array of CategorieTransport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategorieTransport
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
