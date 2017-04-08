<?php

namespace ForestPay\Services\Validation;

use \Validator;

class User extends BaseValidator
{
    /**
     * @var array - rules to apply
     */
    protected $rules = [
        'username' => 'required|unique:users',
        'password' => 'required'
    ];
}