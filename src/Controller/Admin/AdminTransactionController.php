<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 29/07/2024
 */

namespace App\Controller\Admin;

use App\Domain\Transaction\TransactionServices;
use App\Entity\StudentFormation;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\TransactionType;
use App\Repository\StudentFormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/transaction', name: 'admin_transaction_')]
class AdminTransactionController extends AbstractController
{
    public function __construct(private readonly TransactionServices $transactionServices)
    {
    }

    #[Route('/list', name: 'list')]
    public function listTransaction(Request $request): Response
    {
        $pagination = $this->transactionServices->getTransactionPagination($request);

        return $this->render('admin/transaction/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    #[Route('/unpaid', name: 'unpaid')]
    public function listUnpaidUser(Request $request): Response
    {
        $pagination = $this->transactionServices->getAllUpaidFormations($request);

        return $this->render(
            'admin/transaction/index_unpaid.html.twig',
            [
                'search' => $request->get('search'),
                'pagination' => $pagination,
            ]
        );
    }

    #[Route('/generate/{id}', name: 'generate')]
    public function createTransaction(Request $request, StudentFormation $studentFormation): RedirectResponse|Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction = $this->transactionServices->generateTransaction($transaction, $studentFormation);
            $this->transactionServices->validateTransaction($transaction);
            $this->transactionServices->validateByAdmin($transaction);

            return  $this->redirectToRoute('admin_transaction_list');
        }

        return $this->render('admin/transaction/generate_transaction.html.twig', ['form' => $form->createView(), 'formation' => $studentFormation]);
    }

    #[Route('/validate/{id}', name: 'validate')]
    public function validateTransaction(Transaction $transaction): RedirectResponse
    {
        $this->transactionServices->validateByAdmin($transaction);

        return $this->redirectToRoute('admin_transaction_list');
    }
}