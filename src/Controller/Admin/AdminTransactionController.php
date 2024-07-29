<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 29/07/2024
 */

namespace App\Controller\Admin;

use App\Domain\Transaction\TransactionServices;
use App\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/transaction', name: 'admin_transaction_')]
class AdminTransactionController extends AbstractController
{
    public function __construct(private TransactionServices $transactionServices)
    {
    }

    #[Route('/list', name: 'list')]
    public function listTransaction(Request $request): Response
    {
        $pagination = $this->transactionServices->getTransactionPagination($request);

        return $this->render('admin/transaction/index.html.twig', ['pagination' => $pagination]);
    }

    #[Route('/validate/{id}', name: 'validate')]
    public function validateTransaction(Transaction $transaction): RedirectResponse
    {
        $this->transactionServices->validateByAdmin($transaction);

        return $this->redirectToRoute('admin_transaction_list');
    }
}