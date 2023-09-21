<?php

namespace App\Repository;

use App\Entity\SupportFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SupportFormation>
 *
 * @method SupportFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportFormation[]    findAll()
 * @method SupportFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupportFormation::class);
    }

//    /**
//     * @return SupportFormation[] Returns an array of SupportFormation objects
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

//    public function findOneBySomeField($value): ?SupportFormation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
