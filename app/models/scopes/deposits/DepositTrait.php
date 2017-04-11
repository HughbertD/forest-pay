<?php

trait DepositTrait
{
    public static function bootDepositTrait()
    {
        static::addGlobalScope(new DepositScope);
    }
}