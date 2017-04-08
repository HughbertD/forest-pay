<?php

namespace ForestPay\Services\Validation;

abstract class BaseValidator implements ValidationInterface
{
    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * @var array - rules to apply
     */
    protected $rules = [];

    /**
     * @var array - message store to be returned
     */
    protected $messages = [];

    /**
     * @var bool - success of validation
     */
    protected $fails;

    public function __construct(array $input)
    {
        $this->validator = \Validator::make($input, $this->rules);
        $this->fails = $this->validator->fails();
        if ($this->fails) {
            $this->messages = $this->validator->messages();
        }
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * @return mixed
     */
    public function fails()
    {
        return $this->fails;
    }
}