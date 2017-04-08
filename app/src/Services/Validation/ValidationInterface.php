<?php

namespace ForestPay\Services\Validation;

interface ValidationInterface
{
    /**
     * @return boolean
     */
    public function fails();

    /**
     * @return array
     */
    public function messages();
}