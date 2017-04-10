<?php

namespace ForestPay\Events;

use ForestPay\Services\Validation\Transaction;

trait LogsToTransactionsTrait
{
    /**
     * @param array $data
     * @return \Transaction|void
     * @throws \Exception - if unable to validate the transaction
     */
    public function logToTransaction(array $data = [])
    {
        if (empty($data)) {
            return;
        }

        $transactionValidator = new Transaction($data);

        if ($transactionValidator->fails()) {
            throw new \Exception("Failed to validate transaction log");
        }

        $transaction = new \Transaction($transactionValidator->data());
        $transaction->save();
        return $transaction;
    }
}