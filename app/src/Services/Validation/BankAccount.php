<?php

namespace ForestPay\Services\Validation;

class BankAccount extends BaseValidator
{
    protected $rules = [
        'name' => 'required',
        'bank_name' => 'required',
        'iban' => 'required',
        'beneficiary_name' => 'required'
    ];
}