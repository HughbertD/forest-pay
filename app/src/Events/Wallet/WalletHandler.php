<?php

namespace ForestPay\Events\Wallet;

use ForestPay\Services\Validation\Transaction;

class WalletHandler
{
    public function onCreate(\Wallet $wallet)
    {
        $transactionValidator = new Transaction([
            'user_id' => $wallet->user_id,
            'wallet_id' => $wallet->id,
            'event' => 'Wallet Created',
            'data' => json_encode($wallet)
        ]);

        if ($transactionValidator->fails()) {
            throw new \Exception("Failed to validate transaction log");
        }

        $transaction = new \Transaction($transactionValidator->data());
        $transaction->save();
    }
}