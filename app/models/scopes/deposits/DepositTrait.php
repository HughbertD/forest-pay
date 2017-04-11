<?php

trait DepositTrait
{
    public static function bootDepositTrait()
    {
        static::addGlobalScope(new TransactionScope(Deposit::$event));
    }
}