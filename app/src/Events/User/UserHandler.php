<?php

namespace ForestPay\Events\User;

use ForestPay\Services\Validation\Transaction;

class UserHandler
{
    public function onCreate(\User $user)
    {
        $transactionValidator = new Transaction([
            'user_id' => $user->id,
            'event' => 'User Created',
            'data' => json_encode($user)
        ]);

        if ($transactionValidator->fails()) {
            throw new \Exception("Failed to validate transaction log");
        }

        $transaction = new \Transaction($transactionValidator->data());
        $transaction->save();
    }
}