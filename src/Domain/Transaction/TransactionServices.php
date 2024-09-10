<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 29/07/2024
 */

namespace App\Domain\Transaction;

use App\Entity\StudentFormation;
use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class TransactionServices
{
    public function __construct(private readonly TransactionRepository $transactionRepository, private EntityManagerInterface $entityManager, private PaginatorInterface $paginator)
    {
    }

    public function generateTransaction(Transaction $transaction, StudentFormation $studentFormation): Transaction
    {
        $transaction->setFormation($studentFormation);
        $transaction->setUser($studentFormation->getUser());

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $transaction;
    }

    public function validateByAdmin(Transaction $transaction): bool
    {
        $formation = $transaction->getFormation();
        $formationAmount = $formation->getFormation()->getAmount();
        if ($formation->getPaidAmount() >= $formationAmount) {
            if ($formation->getPaidAmount() > $formationAmount) {
                $transaction->setCommentaire(sprintf('Overflow : %s', ($formationAmount - $formation->getPaidAmount())));
            }

            $formation->setIsTotalPaid(true);
        }
        $transaction->setValidByAdmin(true);
        $this->entityManager->flush();

        return true;
    }

    public function getTransactionPagination(Request $request): PaginationInterface
    {
        $query = $this->transactionRepository->getAllTransactions();

        return $this->paginator->paginate($query, $request->query->get('page') ?? 1, 10);
    }

    public function validateTransaction(Transaction $transaction): bool
    {
        $formation = $transaction->getFormation();
        $currentAmount = $transaction->getAmount();
        $formation->setPaidAmount($formation->getPaidAmount() + $currentAmount);

        $transaction->setValidate(true);
        $this->entityManager->flush();

        return true;
    }

    public function getAllUpaidFormations(Request $request): PaginationInterface
    {
        $query = $this->entityManager->getRepository(StudentFormation::class)->getAllUnpaidFormations($request);

        return $this->paginator->paginate($query, $request->query->get('page') ?? 1, 10);
    }

    public function getMyTransactions(User $user)
    {
        return $this->transactionRepository->findBy(['user' => $user]);
    }

    public function getUnpaidFormations(User $user)
    {
        return $this->entityManager->getRepository(StudentFormation::class)->getUnpaidFormationByUser($user);
    }
}