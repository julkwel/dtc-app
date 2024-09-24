<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getAllTransactions(Request $request): Query
    {
        $query = $this->createQueryBuilder('t');

        $search = $request->get('search');
        if (!empty($search)) {
            $query->innerJoin('t.user', 'u');
            $query->orWhere('u.username LIKE :query');
            $query->orWhere('u.firstname LIKE :query');
            $query->orWhere('u.lastname LIKE :query');
            $query->orWhere('t.reference LIKE :query');
            $query->setParameter('query', "%$search%");
        }

        $isValid = $request->get('isValid');
        if (!is_null($isValid)) {
            $query->andWhere('t.isValidByAdmin LIKE :isvalid');
            $query->setParameter('isvalid', $isValid !== '0' );

            if ($isValid === '0') {
                $query->andWhere('t.isValidByAdmin IS NULL');
            }
        }

        return $query->getQuery();
    }
}
