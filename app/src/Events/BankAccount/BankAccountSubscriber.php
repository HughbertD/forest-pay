<?php

namespace ForestPay\Events\BankAccount;

class BankAccountSubscriber
{
    public function subscribe($events)
    {
        $events->listen('eloquent.created: BankAccount', 'ForestPay\Events\BankAccount\BankAccountHandler@onCreate');
    }
}