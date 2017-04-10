<?php

namespace ForestPay\Services\Validation;

class BankAccount extends BaseValidator
{
    /**
     * @var array - rules for validating an account
     * @todo: IBAN proper validation via checksum
     */
    protected $rules = [
        'name' => 'required',
        'bank_name' => 'required',
        'iban' => 'required',
        'beneficiary_name' => 'required'
    ];
}