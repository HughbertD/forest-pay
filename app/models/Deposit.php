<?php


class Deposit extends Transaction
{
    use \DepositTrait;

    protected $table = 'transactions';

    public static $event = 'Deposit';
}