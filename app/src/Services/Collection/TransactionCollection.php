<?php

namespace ForestPay\Services\Collection;

use Illuminate\Database\Eloquent\Collection;

class TransactionCollection extends Collection
{
    public function balance()
    {
        return array_sum(array_column($this->toArray(), 'amount'));
    }
}