<?php

namespace App\Repository;

use App\Entity\ReservationPack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservationPack>
 *
 * @method ReservationPack|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationPack|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationPack[]    findAll()
 * @method ReservationPack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationPackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationPack::class);
    }

    //    /**
    //     * @return ReservationPack[] Returns an array of ReservationPack objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ReservationPack
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    /**
     * Find reservation packs associated with a specific user ID.
     *
     * @param int $userId The ID of the user
     *
     * @return ReservationPack[] An array of ReservationPack objects
     */
    public function findByUserId(int $userId): array
    {
        return $this->createQueryBuilder('rp')
            ->leftJoin('rp.user', 'u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}
