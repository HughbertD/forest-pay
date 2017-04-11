<?php

class Transaction extends Eloquent
{
    public static $event = 'Transaction';

    public $data = [];

    protected $fillable = ['user_id', 'bank_account_id', 'wallet_id', 'amount', 'event', 'data'];

    protected $dataArray;

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

    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getData($key)
    {
        if (!isset($this->dataArray) || is_array($this->dataArray)) {
            $this->dataArray = $this->data;
        }

        if (!isset($this->dataArray[$key])) {
            return null;
        }

        return $this->dataArray[$key];
    }

    public function newCollection(array $models = [])
    {
        return new \ForestPay\Services\Collection\TransactionCollection($models);
    }
}