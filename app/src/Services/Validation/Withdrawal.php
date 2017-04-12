<?php

namespace ForestPay\Services\Validation;

class Withdrawal extends BaseValidator
{
    protected $rules = [
        'amount' => 'required|numeric',
        'wallet_id' => 'required|exists:wallets,id',
        'user_id' => 'required|exists:users,id'
    ];

    protected $customErrorMessages = [
        'wallet_id.required' => 'We are unable to find that user',
        'user_id.required' => 'We are unable to find that user'
    ];
}