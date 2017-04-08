<?php

namespace ForestPay\Services\Validation;

use Illuminate\Support\MessageBag;

/**
 * Class ValidationOfficer
 * Takes ValidationInterface instances ands combines them, validating all input together, essentially Collection pattern
 * @package ForestPay\Validation
 *
 */
class ValidationOfficer implements ValidationInterface
{
    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var bool
     */
    protected $fails = false;

    /**
     * @var MessageBag
     */
    protected $messages;

    public function __construct(ValidationInterface ...$validators)
    {
        $this->messages = new MessageBag();

        foreach ($validators as $validator) {
            $this->validators[] = $validator;

            if ($validator->fails()) {
                $this->fails = true;
                $this->messages()->merge($validator->messages());
            }
        }

        if (empty($this->validators)) {
            throw new \Exception("No validators provided");
        }
    }

    /**
     * @return MessageBag
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * @return bool
     */
    public function fails()
    {
        return $this->fails;
    }
}