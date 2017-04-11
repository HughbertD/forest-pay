<?php

class Transaction extends Eloquent
{
    public static $event = 'Transaction';

    protected $fillable = ['user_id', 'bank_account_id', 'wallet_id', 'amount', 'event', 'data'];

    public function bankAccount()
    {
        return $this->belongsTo('BankAccount');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function wallet()
    {
        return $this->belongsTo('Wallet');
    }
}