<?php

namespace App\Repository;

use App\Entity\Cohorte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cohorte>
 *
 * @method Cohorte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cohorte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cohorte[]    findAll()
 * @method Cohorte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CohorteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cohorte::class);
    }

//    /**
//     * @return Cohorte[] Returns an array of Cohorte objects
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

//    public function findOneBySomeField($value): ?Cohorte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
