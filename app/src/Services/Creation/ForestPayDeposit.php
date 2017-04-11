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

        $deposit->data = json_encode($deposit->toArray());
        $deposit->save();
        return $deposit;
    }
}