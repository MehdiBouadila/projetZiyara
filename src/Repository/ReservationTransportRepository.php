<?php

namespace App\Repository;

use App\Entity\ReservationTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservationTransport>
 *
 * @method ReservationTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationTransport[]    findAll()
 * @method ReservationTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationTransport::class);
    }

   /* public function findAllWithUser(): array
    {
        return $this->createQueryBuilder('rt')
            ->leftJoin('rt.idUser', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();
    }*/
//    /**
//     * @return ReservationTransport[] Returns an array of ReservationTransport objects
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

//    public function findOneBySomeField($value): ?ReservationTransport
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
