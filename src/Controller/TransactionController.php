<?php


namespace App\Controller;

use App\Entity\Account;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\NegativeBalanceException;
use App\Exceptions\TransactionAlreadyExistsException;
use App\Helpers\AccountHelper;
use App\Helpers\TransactionHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TransactionController extends AbstractController
{
    const CONTENT_HEAD = '<?xml version=\"1.0\"?>' . PHP_EOL;
    const CONTENT_OK = '<result status="OK"></result>' . PHP_EOL;
    const CONTENT_INTERNAL_ERROR = '<result status="ERROR" msg="internal server error"></result>' . PHP_EOL;
    const CONTENT_NEGATIVE_BALANCE_ERROR = '<result status="ERROR" msg="insufficient funds"></result>' . PHP_EOL;

    /**
     * @Route(
     *     "/transaction",
     *     name="transaction",
     *     methods={"POST"},
     *     defaults={"_format"="xml"},
     *     condition="request.getContent() matches '/<debit.+?debit>|<credit.+?credit>/'"
     *     )
     * @param Request $request
     * @param TransactionHelper $transactionHelper
     * @param AccountHelper $accountHelper
     * @return Response
     */
    public function transaction(
        Request $request,
        TransactionHelper $transactionHelper,
        AccountHelper $accountHelper
    ) {
        $entityManager = $this->getDoctrine()->getManager();

        $response = new Response(self::CONTENT_HEAD);

        try {

            $transaction = $transactionHelper->buildObject($request->getContent());
            $transactionHelper->validate($transaction);

            $account = $transaction->getUid();

            $newBalance = $transaction->getType() == "debit"
                ? $account->getBalance() - $transaction->getAmount()
                : $account->getBalance() + $transaction->getAmount();

            $account->setBalance($newBalance);
            $accountHelper->validate($account);

            $transaction->setTransactionDate(new \DateTime());
            $entityManager->persist($transaction);
            $entityManager->flush();

        } catch (TransactionAlreadyExistsException $exception) {
            // we will do nothing and return standard 200OK response
        } catch (NegativeBalanceException $exception) {
            return $response
                ->setContent($response->getContent() . self::CONTENT_NEGATIVE_BALANCE_ERROR)
                ->setStatusCode(Response::HTTP_OK);

        } catch (AccountNotFoundException | \Exception $exception) {
            return $response
                ->setContent($response->getContent() . self::CONTENT_INTERNAL_ERROR)
                ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response
            ->setContent($response->getContent() . self::CONTENT_OK)
            ->setStatusCode(Response::HTTP_OK);

    }
}