<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 29/07/2024
 */

namespace App\Controller\Middle;

use App\Domain\Transaction\TransactionServices;
use App\Entity\StudentFormation;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student/transaction', name: 'transaction_')]
class TransactionController extends AbstractController
{
    public function __construct(private readonly TransactionServices $transactionServices)
    {
    }

    #[Route('/my-transactions', name: 'list')]
    public function transactions(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $transactions = $this->transactionServices->getMyTransactions($user);
        $unpaidFormations = $this->transactionServices->getUnpaidFormations($user);

        return $this->render('middle/student_profile/transaction/_my_transaction.html.twig', ['transactions' => $transactions, 'needToPaids' => $unpaidFormations]);
    }

    #[Route('/generate-transaction/{formation}', name: 'generate')]
    public function manageTransaction(Request $request, StudentFormation $formation): RedirectResponse|Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction = $this->transactionServices->generateTransaction($transaction, $formation);

            return  $this->redirectToRoute('transaction_validate', ['transaction' => $transaction->getId()]);
        }

        return $this->render('middle/student_profile/transaction/_generate_transaction.html.twig', ['form' => $form->createView(), 'formation' => $formation]);
    }


    #[Route('/validate-transaction/{transaction}', name: 'validate')]
    public function validateTransaction(Request $request, Transaction $transaction): Response
    {
        if ($request->request->get('confirm')) {
            $this->transactionServices->validateTransaction($transaction);
            $this->addFlash('success', "Paiement enregistré. En attente de validation par l'administrateur.");

            return $this->redirectToRoute('transaction_list');
        }

        return $this->render('middle/student_profile/transaction/validate_transaction.html.twig', ['transaction' => $transaction]);
    }
}