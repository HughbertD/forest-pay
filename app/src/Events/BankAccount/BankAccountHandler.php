<?php

namespace ForestPay\Events\BankAccount;

use ForestPay\Events\LogsToTransactionsTrait;

class BankAccountHandler
{
    use LogsToTransactionsTrait;

    public function onCreate(\BankAccount $bankAccount)
    {
        $this->logToTransaction([
            'user_id' => $bankAccount->user_id,
            'bank_account_id' => $bankAccount->id,
            'event' => 'Bank Account Created',
            'data' => json_encode($bankAccount)
        ]);
    }

}