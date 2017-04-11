<?php

class Withdrawal extends Transaction
{
    use \WithdrawalTrait;

    protected $table = 'transactions';

    public static $event = 'Withdrawal';
}
