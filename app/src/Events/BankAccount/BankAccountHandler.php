<?php

namespace ForestPay\Events\BankAccount;

use ForestPay\Events\EnterNoteTrait;

class BankAccountHandler
{
    use EnterNoteTrait;

    public function onCreate(\BankAccount $bankAccount)
    {
        $this->createNote([
            'user_id' => $bankAccount->user_id,
            'event' => 'Bank Account Created',
            'data' => json_encode($bankAccount)
        ]);
    }

}