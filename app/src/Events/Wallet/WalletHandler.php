<?php

namespace ForestPay\Events\Wallet;

use ForestPay\Events\LogsToTransactionsTrait;

class WalletHandler
{
    use LogsToTransactionsTrait;

    public function onCreate(\Wallet $wallet)
    {
        $this->logToTransaction([
            'user_id' => $wallet->user_id,
            'wallet_id' => $wallet->id,
            'event' => 'Wallet Created',
            'data' => json_encode($wallet)
        ]);
    }
}