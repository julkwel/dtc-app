<?php

namespace App\Repository;

use App\Entity\StudentFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentFormation>
 *
 * @method StudentFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentFormation[]    findAll()
 * @method StudentFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentFormation::class);
    }

//    /**
//     * @return StudentFormation[] Returns an array of StudentFormation objects
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

//    public function findOneBySomeField($value): ?StudentFormation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
