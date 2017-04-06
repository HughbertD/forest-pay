<?php

class Transaction extends Eloquent
{
    public function bankAccount()
    {
        return $this->belongsTo('BankAccount');
    }

    public function wallet()
    {
        return $this->belongsTo('Wallet');
    }
}