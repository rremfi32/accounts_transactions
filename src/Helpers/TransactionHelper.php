<?php


namespace App\Helpers;


use App\Entity\Transaction;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\TransactionAlreadyExistsException;
use App\Repository\AccountRepository;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use \Exception as Exception;

class TransactionHelper
{
    private $validator;
    private $accountRepository;


    /**
     * TransactionHelper constructor.
     * @param ValidatorInterface $validator
     * @param AccountRepository $repository
     */
    public function __construct(ValidatorInterface $validator, AccountRepository $repository){
        $this->validator = $validator;
        $this->accountRepository = $repository;
    }

    /**
     * @param string $requestContent
     * @return Transaction
     * @throws AccountNotFoundException
     */
    public function buildObject(string $requestContent) {

        $crawler = new Crawler($requestContent);
        $type = $crawler->getNode(0)->nodeName;
        $crawler = $crawler->filter($type);

        $amount = $crawler->attr("amount");
        $amount = filter_var($amount,FILTER_VALIDATE_INT) ? intval($amount) : 0;
        $tid = htmlspecialchars($crawler->attr("tid"));
        $uid = htmlspecialchars($crawler->attr("uid"));

        $account = $this->accountRepository->findOneBy(["uid" => $uid]);
        if (!$account)
            throw new AccountNotFoundException("user is not found");

        $transaction = new Transaction();

        $transaction
            ->setType($type)
            ->setAmount($amount)
            ->setTid($tid)
            ->setUid($account);

        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @throws Exception
     */
    public function validate(Transaction $transaction):void {
        $errors = $this->validator->validate($transaction);

        if (isset($errors) && count($errors)) {
            foreach ($errors as $violation) {
                if ($violation->getMessage() === 'This value is already used.')
                    throw new TransactionAlreadyExistsException();
            }

            // if we have other errors return standard exception
            throw new Exception();
        }

    }

}