<?php

namespace ForestPay\Services\Validation;


class Profile extends BaseValidator
{
    /**
     * @var array - rules to apply
     */
    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required'
    ];
}