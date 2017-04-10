<?php

namespace ForestPay\Events\User;

use ForestPay\Events\LogsToTransactionsTrait;

class UserHandler
{
    use LogsToTransactionsTrait;

    public function onCreate(\User $user)
    {
        $this->logToTransaction([
            'user_id' => $user->id,
            'event' => 'User Created',
            'data' => json_encode($user)
        ]);
    }

    public function wasRegistered(\User $user)
    {
        $this->logToTransaction([
            'user_id' => $user->id,
            'event' => 'User Registered',
            'data' => json_encode($user)
        ]);
    }
}