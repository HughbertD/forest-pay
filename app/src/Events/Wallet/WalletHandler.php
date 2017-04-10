<?php

namespace ForestPay\Events\Wallet;

use ForestPay\Events\EnterNoteTrait;

class WalletHandler
{
    use EnterNoteTrait;

    public function onCreate(\Wallet $wallet)
    {
        $this->createNote([
            'user_id' => $wallet->user_id,
            'event' => 'Wallet Created',
            'data' => json_encode($wallet)
        ]);
    }
}