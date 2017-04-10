<?php

namespace ForestPay\Services\Validation;


class Transaction extends BaseValidator
{
    /**
     * @var array - rules to apply
     */
    protected $rules = [
        'amount' => 'sometimes|required|numeric',
        'event' => 'required'
    ];
}