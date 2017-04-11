<?php

trait WithdrawalTrait
{
    public static function bootWithdrawalTrait()
    {
        static::addGlobalScope(new TransactionScope(Withdrawal::$event));
    }
}