<?php

namespace ForestPay\Services\Creation;


class ForestPayDeposit
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->data['event'] = \Deposit::$event;
        $this->data['data'] = '';
    }

    public function build()
    {
        $deposit = new \Deposit($this->data);
        $deposit->save();

        $deposit->data = json_encode(array_merge($deposit->toArray(), $this->data));
        $deposit->save();
        return $deposit;
    }
}