<?php

namespace App\Helpers;

use App\Entity\Account;
use App\Exceptions\NegativeBalanceException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use \Exception as Exception;

class AccountHelper
{
    private $validator;

    public function __construct(ValidatorInterface $validator){
        $this->validator = $validator;
    }

    /**
     * @param Account $account
     * @throws Exception
     */
    public function validate(Account $account):void {
        $errors = $this->validator->validate($account);

        if (isset($errors) && count($errors)) {
            foreach ($errors as $violation) {
                if ($violation->getMessage() === 'balance negative error')
                    throw new NegativeBalanceException();
            }

            // if we have other errors return standard exception
            throw new Exception();
        }
    }

}