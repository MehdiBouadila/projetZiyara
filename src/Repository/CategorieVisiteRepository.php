<?php

namespace App\Repository;

use App\Entity\CategorieVisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieVisite>
 *
 * @method CategorieVisite|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieVisite|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieVisite[]    findAll()
 * @method CategorieVisite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieVisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieVisite::class);
    }

//    /**
//     * @return CategorieVisite[] Returns an array of CategorieVisite objects
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

//    public function findOneBySomeField($value): ?CategorieVisite
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
