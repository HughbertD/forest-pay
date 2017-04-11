<?php

namespace ForestPay\Services\Validation;

class Deposit extends BaseValidator
{
    protected $rules = [
        'amount' => 'required|numeric',
        'to_user' => 'required|email',
        'wallet_id' => 'required|exists:wallets,id',
        'user_id' => 'required|exists:users,id'
    ];

    protected $customErrorMessages = [
        'wallet_id.required' => 'We are unable to find that user',

        'user_id.required' => 'We are unable to find that user'
    ];
}