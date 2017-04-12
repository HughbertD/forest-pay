<?php

namespace ForestPay\Services\Validation;

class Withdrawal extends BaseValidator
{
    protected $rules = [
        'amount' => 'required|numeric|min:10',
        'wallet_id' => 'required|exists:wallets,id',
        'user_id' => 'required|exists:users,id'
    ];

    protected $customErrorMessages = [
        'wallet_id.required' => 'We are unable to find that user',
        'user_id.required' => 'We are unable to find that user',
        'amount.max' => 'You do not have enough funds'
    ];

    public function __construct(array $input, $balance)
    {
        $this->rules['amount'].="|max:{$balance}";
        $this->validator = \Validator::make($input, $this->rules, $this->customErrorMessages);
        $this->fails = $this->validator->fails();
        if ($this->fails) {
            $this->messages = $this->validator->messages();
        }
        $this->data = $input;
    }
}