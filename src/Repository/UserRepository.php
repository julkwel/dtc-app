<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllUsers(Request $request): Query
    {
        $qb = $this->createQueryBuilder('u');

        $search = $request->get('search');
        $role = $request->get('role');
        if (!empty($search)) {
            $qb->orWhere('u.username LIKE :query');
            $qb->orWhere('u.firstname LIKE :query');
            $qb->orWhere('u.lastname LIKE :query');
            $qb->setParameter('query', "%$search%");
        }

        if (!empty($role)) {
            $qb->andWhere('u.roles LIKE :role')
                ->setParameter('role', "%$role%");
        }
        return $qb->getQuery();
    }

    public function getUserByRole(string $role = 'ROLE_STUDENT'): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :role')
            ->andWhere('u.isEnabled =true')
            ->setParameter('role', "%$role%")
            ->getQuery()
            ->getResult();
    }
}
