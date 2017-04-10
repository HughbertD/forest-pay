<?php

namespace ForestPay\Services\Validation;

class Note extends BaseValidator
{
    protected $rules = [
        'event' => 'required',
        'data' => 'required',
        'user_id' => 'required|exists:users,id'
    ];
}