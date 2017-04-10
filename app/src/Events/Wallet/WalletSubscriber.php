<?php

namespace ForestPay\Events\Wallet;


class WalletSubscriber
{
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Wallet', 'ForestPay\Events\Wallet\WalletHandler@onCreate');
    }
}