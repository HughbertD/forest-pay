<?php

namespace ForestPay\Services\Filters;

use Illuminate\Http\Request;

interface OwnerFilterInterface
{
    public function filter();

    public function getInputValue(Request $request);

    public function getAllowedValuesFromUser(\User $user);
}
