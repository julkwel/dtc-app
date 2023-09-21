<?php

namespace App\Repository;

use App\Entity\TrainerFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainerFormation>
 *
 * @method TrainerFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainerFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainerFormation[]    findAll()
 * @method TrainerFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainerFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainerFormation::class);
    }

//    /**
//     * @return TrainerFormation[] Returns an array of TrainerFormation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TrainerFormation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
